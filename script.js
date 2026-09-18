// Reveal elements on scroll
const revealObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add("show");
    observer.unobserve(entry.target);
  });
}, { threshold: 0.12 });

document.querySelectorAll(".reveal").forEach(el => revealObserver.observe(el));

// Program filter
const tabs = document.querySelectorAll(".program-tab");
const programCards = document.querySelectorAll(".program-card");

tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    tabs.forEach(item => item.classList.remove("active"));
    tab.classList.add("active");

    const filter = tab.dataset.filter;

    programCards.forEach(card => {
      const matches = filter === "all" || card.dataset.category === filter;
      card.style.display = matches ? "" : "none";
    });
  });
});

// Animated statistics
const stats = document.querySelectorAll("[data-count]");

const statObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;

    const target = Number(entry.target.dataset.count);
    const duration = target > 1000 ? 1300 : 900;
    const start = performance.now();

    function animate(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const value = Math.floor(target * eased);

      // Don't add comma to Year Established
      if (target === 1971) {
        entry.target.textContent = value;
      } else {
        entry.target.textContent = value.toLocaleString();
      }

      if (progress < 1) {
        requestAnimationFrame(animate);
      }
    }

    requestAnimationFrame(animate);
    observer.unobserve(entry.target);
  });
}, { threshold: 0.6 });

stats.forEach(stat => statObserver.observe(stat));


// Back to top
const backTop = document.getElementById("backTop");

window.addEventListener("scroll", () => {
  backTop.classList.toggle("show", window.scrollY > 500);
});

backTop.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});


// Mobile navigation
const nav = document.getElementById("mainNav");
const menuToggle = document.querySelector(".menu-toggle");
menuToggle?.addEventListener("click", () => {
  nav.classList.toggle("open");
});

// Mobile dropdowns
document.querySelectorAll(".nav-dropdown > button").forEach(button => {
  button.addEventListener("click", () => {
    if (window.innerWidth <= 760) {
      button.parentElement.classList.toggle("open");
    }
  });
});



/* PROGRAM EVENTS CAROUSEL */
document.addEventListener("DOMContentLoaded", () => {
	const programEvents = document.getElementById("programEvents");
	const programPrev = document.getElementById("programPrev");
	const programNext = document.getElementById("programNext");
	const programDots = document.getElementById("programEventDots");

	if (!programEvents || !programPrev || !programNext || !programDots) return;

	const cards = Array.from(programEvents.querySelectorAll(".feature-card"));
	let currentPage = 0;

	function getCardsPerPage() {
		if (window.innerWidth <= 650) return 1;
		if (window.innerWidth <= 1100) return 2;
		return 4;
	}

	function getTotalPages() {
		return Math.max(1, Math.ceil(cards.length / getCardsPerPage()));
	}

	function createDots() {
		programDots.innerHTML = "";

		const totalPages = getTotalPages();

		for (let i = 0; i < totalPages; i++) {
			const dot = document.createElement("button");
			dot.type = "button";
			dot.className = "program-event-dot";
			dot.setAttribute("aria-label", `Go to program events page ${i + 1}`);

			dot.addEventListener("click", () => {
				currentPage = i;
				updateCarousel();
			});

			programDots.appendChild(dot);
		}
	}

	function updateCarousel() {
		const cardsPerPage = getCardsPerPage();
		const totalPages = getTotalPages();

		if (currentPage >= totalPages) {
			currentPage = totalPages - 1;
		}

		if (currentPage < 0) {
			currentPage = 0;
		}

		if (cards.length > cardsPerPage) {
			const cardWidth = cards[0].offsetWidth;
			const gap = parseFloat(getComputedStyle(programEvents).gap) || 0;
			const moveDistance = (cardWidth + gap) * cardsPerPage * currentPage;

			programEvents.style.transform = `translateX(-${moveDistance}px)`;
		} else {
			programEvents.style.transform = "translateX(0)";
		}

		const dots = programDots.querySelectorAll(".program-event-dot");

		dots.forEach((dot, index) => {
			dot.classList.toggle("active", index === currentPage);
		});

		programPrev.disabled = currentPage === 0;
		programNext.disabled = currentPage === totalPages - 1;
	}

	programPrev.addEventListener("click", () => {
		if (currentPage > 0) {
			currentPage--;
			updateCarousel();
		}
	});

	programNext.addEventListener("click", () => {
		if (currentPage < getTotalPages() - 1) {
			currentPage++;
			updateCarousel();
		}
	});

	window.addEventListener("resize", () => {
		createDots();
		updateCarousel();
	});

	createDots();
	updateCarousel();
});