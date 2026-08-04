export default {
  async fetch(request, env, ctx) {
    // 1. Get the URL you want to scrape from the query parameter
    // Example: https://your-worker.workers.dev/?url=https://cisco.com/partner
    const url = new URL(request.url);
    const targetUrl = url.searchParams.get("url");

    if (!targetUrl) {
      return new Response("Missing 'url' query parameter", { status: 400 });
    }

    try {
      // 2. Clone the headers from the Python scraper (e.g. User-Agent)
      const modifiedHeaders = new Headers(request.headers);
      
      // Remove headers that might expose Cloudflare or cause issues
      modifiedHeaders.delete("x-forwarded-for");
      modifiedHeaders.delete("cf-connecting-ip");
      modifiedHeaders.delete("host");

      // 3. Fetch the target URL using Cloudflare's global IP network
      const response = await fetch(targetUrl, {
        method: request.method,
        headers: modifiedHeaders,
        body: request.method !== "GET" && request.method !== "HEAD" ? request.body : null,
        redirect: "follow"
      });

      // 4. Return the HTML back to your Python scraper
      return new Response(response.body, {
        status: response.status,
        headers: response.headers
      });
      
    } catch (e) {
      return new Response(`Proxy Error: ${e.message}`, { status: 500 });
    }
  }
};
