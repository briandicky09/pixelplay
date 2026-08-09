// PixelPlay — landing page interactions

document.addEventListener("DOMContentLoaded", () => {
  /* ---------------- Mobile menu ---------------- */
  const menuToggle = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const iconOpen = document.getElementById("iconOpen");
  const iconClose = document.getElementById("iconClose");

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener("click", () => {
      const isOpen = !mobileMenu.classList.contains("hidden");
      mobileMenu.classList.toggle("hidden");
      iconOpen.classList.toggle("hidden");
      iconClose.classList.toggle("hidden");
      menuToggle.setAttribute("aria-expanded", String(!isOpen));
    });

    mobileMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        mobileMenu.classList.add("hidden");
        iconOpen.classList.remove("hidden");
        iconClose.classList.add("hidden");
        menuToggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* ---------------- Sticky navbar shadow ---------------- */
  const navbar = document.getElementById("navbar");
  if (navbar) {
    const onScroll = () => {
      if (window.scrollY > 8) {
        navbar.classList.add("border-charcoal-700", "shadow-card");
        navbar.classList.remove("border-transparent");
      } else {
        navbar.classList.remove("border-charcoal-700", "shadow-card");
        navbar.classList.add("border-transparent");
      }
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* ---------------- Scroll reveal ---------------- */
  const revealEls = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window && revealEls.length) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach((el, i) => {
      el.style.transitionDelay = `${Math.min(i % 6, 5) * 60}ms`;
      io.observe(el);
    });
  } else {
    revealEls.forEach((el) => el.classList.add("is-visible"));
  }

  /* ---------------- Hero slider ---------------- */
  const slider = document.getElementById("heroSlider");
  if (!slider) return;

  const slides = Array.from(slider.querySelectorAll(".hero-slide"));
  const dots = Array.from(document.querySelectorAll(".hero-dot"));
  const prevBtn = document.getElementById("heroPrev");
  const nextBtn = document.getElementById("heroNext");
  const progressBar = document.getElementById("heroProgress");
  const counter = document.getElementById("heroCounter");
  const total = slides.length;

  const AUTOPLAY_MS = 6000;
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  let index = 0;
  let elapsed = 0;
  let lastTime = null;
  let rafId = null;
  let isPaused = false;
  let isTabHidden = false;
  let touchStartX = null;

  function render() {
    slides.forEach((slide, i) => {
      const active = i === index;
      slide.classList.toggle("opacity-100", active);
      slide.classList.toggle("opacity-0", !active);
      slide.classList.toggle("pointer-events-none", !active);
    });
    dots.forEach((dot, i) => {
      const active = i === index;
      dot.setAttribute("aria-selected", String(active));
      dot.classList.toggle("w-8", active);
      dot.classList.toggle("bg-violet-500", active);
      dot.classList.toggle("w-2.5", !active);
      dot.classList.toggle("bg-charcoal-600", !active);
    });
    if (counter) {
      counter.textContent = `${String(index + 1).padStart(2, "0")} / ${String(total).padStart(2, "0")}`;
    }
  }

  function goTo(next) {
    elapsed = 0;
    lastTime = null;
    if (progressBar) progressBar.style.width = "0%";
    index = ((next % total) + total) % total;
    render();
  }

  function next() {
    goTo(index + 1);
  }

  function prev() {
    goTo(index - 1);
  }

  function tick(timestamp) {
    if (lastTime === null) lastTime = timestamp;
    const delta = timestamp - lastTime;
    lastTime = timestamp;

    elapsed = Math.min(elapsed + delta, AUTOPLAY_MS);
    const pct = (elapsed / AUTOPLAY_MS) * 100;
    if (progressBar) progressBar.style.width = `${pct}%`;

    if (elapsed >= AUTOPLAY_MS) {
      next();
      rafId = window.requestAnimationFrame(tick);
      return;
    }
    rafId = window.requestAnimationFrame(tick);
  }

  function startLoop() {
    if (reduceMotion || total < 2 || isPaused || isTabHidden) return;
    if (rafId !== null) return;
    lastTime = null;
    rafId = window.requestAnimationFrame(tick);
  }

  function stopLoop() {
    if (rafId !== null) {
      window.cancelAnimationFrame(rafId);
      rafId = null;
    }
  }

  function restartLoop() {
    stopLoop();
    startLoop();
  }

  // Prev / next buttons
  if (prevBtn) prevBtn.addEventListener("click", () => { prev(); restartLoop(); });
  if (nextBtn) nextBtn.addEventListener("click", () => { next(); restartLoop(); });

  // Dots
  dots.forEach((dot) => {
    dot.addEventListener("click", () => {
      const target = Number(dot.dataset.goto);
      goTo(target);
      restartLoop();
    });
  });

  // Keyboard navigation
  slider.addEventListener("keydown", (event) => {
    if (event.key === "ArrowRight") {
      event.preventDefault();
      next();
      restartLoop();
    }
    if (event.key === "ArrowLeft") {
      event.preventDefault();
      prev();
      restartLoop();
    }
  });

  // Swipe support
  function endSwipe(endX) {
    if (touchStartX != null && endX != null) {
      const delta = endX - touchStartX;
      if (Math.abs(delta) > 48) {
        delta < 0 ? next() : prev();
      }
    }
    touchStartX = null;
    isPaused = false;
    restartLoop();
  }

  slider.addEventListener(
    "touchstart",
    (event) => {
      touchStartX = event.touches[0]?.clientX ?? null;
      isPaused = true;
      stopLoop();
    },
    { passive: true }
  );
  slider.addEventListener(
    "touchmove",
    () => {
      // Gesture still active — autoplay stays paused (set in touchstart).
      // No extra timers/state; this listener exists only for explicit
      // touchmove handling as required.
    },
    { passive: true }
  );
  slider.addEventListener(
    "touchend",
    (event) => {
      endSwipe(event.changedTouches[0]?.clientX ?? null);
    },
    { passive: true }
  );
  slider.addEventListener(
    "touchcancel",
    () => {
      // Interrupted gesture (system gesture, incoming call, etc.) must
      // never leave autoplay stuck paused — this was the freeze bug.
      endSwipe(null);
    },
    { passive: true }
  );

  // Hover must NEVER pause the slideshow — intentionally no
  // mouseenter/mouseleave listeners on the slider.

  // Pause when tab is hidden
  document.addEventListener("visibilitychange", () => {
    isTabHidden = document.hidden;
    if (isTabHidden) {
      stopLoop();
    } else {
      startLoop();
    }
  });

  render();
  startLoop();
});
