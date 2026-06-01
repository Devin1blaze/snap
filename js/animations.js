document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-count]');
    const speed = 200; // The lower the slower

    const animate = (counter) => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-count');
            const suffix = counter.getAttribute('data-suffix') || '';
            // Strip the suffix before parsing to number
            let currentText = counter.innerText;
            if (suffix && currentText.endsWith(suffix)) {
                currentText = currentText.slice(0, -suffix.length);
            }
            const count = +currentText;

            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc) + suffix;
                setTimeout(updateCount, 10);
            } else {
                counter.innerText = target + suffix;
            }
        };

        updateCount();
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animate(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        observer.observe(counter);
    });

    // Scroll Reveal Observer
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                
                // Animate SVG path if present
                const path = entry.target.querySelector('[data-animated-path="true"]');
                if (path) {
                    const length = path.getTotalLength();
                    path.style.strokeDasharray = length;
                    path.style.strokeDashoffset = length;
                    path.getBoundingClientRect(); // trigger reflow
                    path.style.transition = 'stroke-dashoffset 2s ease-in-out';
                    path.style.strokeDashoffset = '0';
                }
            } else {
                entry.target.classList.remove('active');
                
                // Reset SVG path
                const path = entry.target.querySelector('[data-animated-path="true"]');
                if (path) {
                    const length = path.getTotalLength();
                    path.style.strokeDashoffset = length;
                }
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    });

    document.querySelectorAll('.scroll-reveal, section#process-management').forEach(el => {
        revealObserver.observe(el);
    });
});
