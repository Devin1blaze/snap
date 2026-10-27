"""
Hermes Cisco Scraper Tool (Oracle VPS entry point).

Designed to be invoked by the Hermes agent via its `execute_code` sandbox:

    python hermes_cisco_tool.py <country> [--max N] [--resume]
                                [--time-budget MINUTES]
                                [--notify telegram,email]

Behavior:
- Runs the full cisco_pipeline in-process with an optional time budget so a
  single invocation can never exceed the runtime Hermes allots (Oracle
  pay-as-you-go: 1500 h/month cap — budget is a per-call parameter).
- Prints exactly ONE machine-readable SUMMARY line at the end so Hermes'
  LLM context stays small. Pipeline chatter goes to `hermes_run.log` instead
  of stdout.

SUMMARY line format (pipe-separated):
  SUMMARY|status=<done|resumable|error>|country=<name>|rows=<n>|csv=<path>|xlsx=<path>|notify=<results>

  status=resumable  -> re-invoke with the same country plus --resume
"""
import argparse
import contextlib
import csv
import os
import sys
import asyncio

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, BASE_DIR)

from cisco_pipeline import run_pipeline, EXIT_RESUMABLE  # noqa: E402
import notification_sender  # noqa: E402

LOG_FILE = os.path.join(BASE_DIR, "hermes_run.log")


def _count_rows(csv_path: str) -> int:
    try:
        with open(csv_path, "r", encoding="utf-8", newline="") as f:
            return max(sum(1 for _ in csv.reader(f)) - 1, 0)
    except Exception:
        return 0


def main():
    parser = argparse.ArgumentParser(description="Hermes wrapper for the Cisco Partner pipeline")
    parser.add_argument("country", help="Country name to scrape (e.g., Oman)")
    parser.add_argument("--max", type=int, default=None, help="Max partners (testing)")
    parser.add_argument("--resume", action="store_true", help="Resume from checkpoint")
    parser.add_argument("--time-budget", type=float, default=None,
                        help="Max runtime in minutes for this invocation")
    parser.add_argument("--notify", default="",
                        help="Comma-separated delivery channels on success: telegram,email")
    args = parser.parse_args()

    country_suffix = args.country.replace(" ", "_")
    csv_path = os.path.join(BASE_DIR, f"Cisco_Partners_{country_suffix}.csv")
    xlsx_path = os.path.join(BASE_DIR, f"Cisco_Partners_{country_suffix}.xlsx")

    status = "done"
    # Redirect the pipeline's verbose output to a log file to keep Hermes'
    # context clean; only the SUMMARY line goes to stdout.
    with open(LOG_FILE, "a", encoding="utf-8") as log:
        log.write(f"\n===== RUN country={args.country} max={args.max} resume={args.resume} "
                  f"budget={args.time_budget} =====\n")
        try:
            with contextlib.redirect_stdout(log), contextlib.redirect_stderr(log):
                asyncio.run(run_pipeline(args.country, args.max, args.resume, args.time_budget))
        except SystemExit as e:
            if e.code == EXIT_RESUMABLE:
                status = "resumable"
            elif e.code not in (0, None):
                status = "error"
        except Exception as e:
            log.write(f"FATAL: {e}\n")
            status = "error"

    notify_result = "skipped"
    if status == "done" and args.notify:
        channels = [c.strip() for c in args.notify.split(",") if c.strip()]
        send_file = xlsx_path if os.path.exists(xlsx_path) else csv_path
        if os.path.exists(send_file):
            results = notification_sender.dispatch(
                send_file, channels,
                caption=f"Cisco Partners {args.country} — {_count_rows(csv_path)} rows")
            notify_result = ",".join(f"{k}={'ok' if v else 'fail'}" for k, v in results.items())
        else:
            notify_result = "no_file"

    rows = _count_rows(csv_path) if os.path.exists(csv_path) else 0
    print(f"SUMMARY|status={status}|country={args.country}|rows={rows}"
          f"|csv={csv_path if os.path.exists(csv_path) else '-'}"
          f"|xlsx={xlsx_path if os.path.exists(xlsx_path) else '-'}"
          f"|notify={notify_result}")
    if status == "resumable":
        print(f"NEXT|python hermes_cisco_tool.py \"{args.country}\" --resume"
              + (f" --time-budget {args.time_budget}" if args.time_budget else "")
              + (f" --notify {args.notify}" if args.notify else ""))

    sys.exit(0 if status in ("done", "resumable") else 1)


if __name__ == "__main__":
    main()
