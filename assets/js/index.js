// Lightbox
Array.from(document.querySelectorAll("[data-lightbox]")).forEach(element => {
  element.onclick = (e) => {
    e.preventDefault();
    basicLightbox.create(`<img src="${element.href}">`).show();
  };
});

document.addEventListener("DOMContentLoaded", function () {
  const titles = document.querySelectorAll(".airsalon-title");

  titles.forEach((title) => {
    title.addEventListener("click", function (event) {
      event.preventDefault();
      const targetId = this.getAttribute("data-toggle");
      const details = document.getElementById(targetId);

      if (details.style.height === "0px" || details.style.height === "") {
        // Expand the description
        details.style.height = details.scrollHeight + "px";
      } else {
        // Collapse the description
        details.style.height = "0px";
      }
    });
  });

  const playButtons = document.querySelectorAll(".play-button");
  const mixcloudPlayerContainer = document.getElementById("global-mixcloud-player");
  const mixcloudIframe = document.getElementById("mixcloud-iframe");

  playButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const audioLink = this.getAttribute("data-audio");
      console.log("Audio Link:", audioLink); // Debugging: Log the audio link

      // If the player is already open with the same link, toggle pause/play
      if (mixcloudPlayerContainer.classList.contains("visible") && mixcloudIframe.src.includes(audioLink)) {
        console.log("Toggling playback...");
        mixcloudIframe.contentWindow.postMessage('{"method": "toggle"}', "*");
      } else {
        console.log("Updating Mixcloud iframe...");
        mixcloudIframe.src = ""; // Reset the iframe

        // Pass the audioLink directly with autoplay enabled
        mixcloudIframe.src = `https://www.mixcloud.com/widget/iframe/?feed=${audioLink}&hide_cover=1&mini=1&autoplay=1&light=1`;

        // Wait for the iframe to load, then send the play command
        mixcloudIframe.onload = function () {
          mixcloudIframe.contentWindow.postMessage('{"method": "play"}', "*");
        };

        mixcloudPlayerContainer.classList.add("visible"); // Add the visible class for smooth appearance
      }
    });
  });

  // Optional: Add a close button to hide the player
  const closeButton = document.createElement("button");
  closeButton.textContent = "Close";
  closeButton.style.position = "absolute";
  closeButton.style.top = "16px";
  closeButton.style.right = "10px";
  closeButton.style.background = "#FF4A00";
  closeButton.style.color = "#fff";
  closeButton.style.border = "none";
  closeButton.style.padding = "5px 25px";
  closeButton.style.cursor = "pointer";
  closeButton.style.transition = "background 0.3s, color 0.3s"; // Smooth transition for hover effects

  // Add hover effect
  closeButton.addEventListener("mouseenter", function () {
    closeButton.style.background = "#D0FAFF";
    closeButton.style.color = "#FF4A00";
  });

  closeButton.addEventListener("mouseleave", function () {
    closeButton.style.background = "#FF4A00";
    closeButton.style.color = "#fff";
  });

  closeButton.addEventListener("click", function () {
    mixcloudPlayerContainer.classList.remove("visible");
    mixcloudIframe.src = ""; // Stop the player
  });
  mixcloudPlayerContainer.appendChild(closeButton);

  const smoothScrollLinks = document.querySelectorAll('a[href^="#"]'); // Select all anchor links starting with #

  smoothScrollLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent default anchor behavior
      const targetId = this.getAttribute("href").substring(1); // Get the target ID (remove the #)
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: "smooth", // Enable smooth scrolling
          block: "start", // Align to the top of the section
        });
      }
    });
  });

  const yearToggleButton = document.getElementById("year-toggle-button");
  const yearList = document.getElementById("year-list");
  const yearLinks = document.querySelectorAll(".year-link");
  const airsalonItems = document.querySelectorAll(".airsalon-item");

  // Align the button with the first radio show on page load
  const firstRadioShow = document.querySelector(".airsalon-item"); // Select the first radio show

  if (firstRadioShow) {
    const firstRadioShowRect = firstRadioShow.getBoundingClientRect();
    const archiveSection = document.querySelector(".airsalon-archive");
    const archiveSectionRect = archiveSection.getBoundingClientRect();

    // Calculate the top position relative to the archive section
    const offsetTop = firstRadioShowRect.top - archiveSectionRect.top;
    yearToggleButton.style.top = `${offsetTop}px`;
  }

  // Toggle the visibility of the year list
  yearToggleButton.addEventListener("click", function () {
    if (yearList.style.display === "none") {
      yearList.style.display = "block";
    } else {
      yearList.style.display = "none";
    }
  });

  // Smooth scrolling to the selected year
  yearLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const targetId = this.getAttribute("href").substring(1); // Remove the # from the href
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        const offset = -55; // Adjust this value to align correctly (e.g., -50px above the target)
        const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY + offset;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth", // Enable smooth scrolling
        });

        yearList.style.display = "none"; // Hide the year list after selection
      }
    });
  });

  // Update the button text based on the button's alignment with the radio shows
  const updateButtonYear = () => {
    let currentYear = "";
    const buttonRect = yearToggleButton.getBoundingClientRect();
    const offset = 20; // Adjust this value to change the sensitivity (e.g., 50px earlier)

    airsalonItems.forEach((item) => {
      const itemRect = item.getBoundingClientRect();
      if (buttonRect.top + offset >= itemRect.top && buttonRect.top + offset <= itemRect.bottom) {
        currentYear = item.id.replace("year-", "");
      }
    });

    if (currentYear) {
      yearToggleButton.textContent = currentYear;
    }
  };

  // Update the button year on scroll
  window.addEventListener("scroll", updateButtonYear);

  // Initial update on page load
  updateButtonYear();

  const nextShowLink = document.querySelector(".next-show-link");

  if (nextShowLink) {
    nextShowLink.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent default anchor behavior
      const targetId = this.getAttribute("href").substring(1); // Get the target ID (remove the #)
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        const offset = -100; // Adjust this value to align correctly (e.g., -100px above the target)
        const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY + offset;

        // Smoothly scroll to the target element
        window.scrollTo({
          top: targetPosition,
          behavior: "smooth", // Enable smooth scrolling
        });

        // Expand the description after scrolling
        setTimeout(() => {
          const details = targetElement.querySelector(".airsalon-details");
          if (details) {
            details.style.height = details.scrollHeight + "px"; // Expand the description
            details.style.overflow = "visible"; // Ensure content is visible
          }
        }, 100); // Delay to ensure scrolling is complete
      }
    });
  }
});

// Toggle Menu
  const toggle = document.querySelector('.menu-toggle');
  const menu = document.querySelector('.menu');

  toggle.addEventListener('click', () => {
    menu.classList.toggle('open');
  });

  // Project space slider

document.querySelectorAll('.projectspace-slider').forEach(slider => {
  const slidesWrapper = slider.querySelector('.slides-wrapper');
  const slides = slidesWrapper.querySelectorAll('.slide');
  const leftZone = slider.querySelector('.left-zone');
  const rightZone = slider.querySelector('.right-zone');
  let index = 0;

  const setPositionByIndex = () => {
    const width = slider.offsetWidth;
    const translateX = index * -width;
    slidesWrapper.style.transform = `translateX(${translateX}px)`;
  };

  // --- Click zone handlers ---
  const onLeftClick = () => {
    if (index > 0) {
      index--;
      setPositionByIndex();
    }
  };

  const onRightClick = () => {
    if (index < slides.length - 1) {
      index++;
      setPositionByIndex();
    }
  };

  // --- Drag/swipe handlers ---
  let isDragging = false;
  let startPos = 0;
  let currentTranslate = 0;
  let prevTranslate = 0;
  let animationID;

  const getPositionX = (event) => event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;

  const animation = () => {
    slidesWrapper.style.transform = `translateX(${currentTranslate}px)`;
    if (isDragging) requestAnimationFrame(animation);
  };

  const touchStart = (event) => {
    isDragging = true;
    startPos = getPositionX(event);
    animationID = requestAnimationFrame(animation);
  };

  const touchMove = (event) => {
    if (!isDragging) return;
    const currentPosition = getPositionX(event);
    currentTranslate = prevTranslate + currentPosition - startPos;
  };

  const touchEnd = () => {
    cancelAnimationFrame(animationID);
    isDragging = false;
    const movedBy = currentTranslate - prevTranslate;
    if (movedBy < -100 && index < slides.length - 1) index++;
    if (movedBy > 100 && index > 0) index--;
    prevTranslate = index * -slider.offsetWidth;
    currentTranslate = prevTranslate;
    slidesWrapper.style.transform = `translateX(${currentTranslate}px)`;
  };

  // --- Enable desktop behavior ---
  function enableDesktop() {
    // Show click zones
    if (leftZone) leftZone.style.display = 'block';
    if (rightZone) rightZone.style.display = 'block';

    // Add click zone listeners
    if (leftZone) leftZone.addEventListener('click', onLeftClick);
    if (rightZone) rightZone.addEventListener('click', onRightClick);

    // Remove drag/swipe listeners
    slidesWrapper.removeEventListener('touchstart', touchStart);
    slidesWrapper.removeEventListener('touchmove', touchMove);
    slidesWrapper.removeEventListener('touchend', touchEnd);
    slidesWrapper.removeEventListener('mousedown', touchStart);
    slidesWrapper.removeEventListener('mousemove', touchMove);
    slidesWrapper.removeEventListener('mouseup', touchEnd);
    slidesWrapper.removeEventListener('mouseleave', touchEnd);
  }

  // --- Enable mobile behavior ---
  function enableMobile() {
    // Hide click zones
    if (leftZone) leftZone.style.display = 'none';
    if (rightZone) rightZone.style.display = 'none';

    // Remove click listeners
    if (leftZone) leftZone.removeEventListener('click', onLeftClick);
    if (rightZone) rightZone.removeEventListener('click', onRightClick);

    // Add drag/swipe listeners
    slidesWrapper.addEventListener('touchstart', touchStart, { passive: true });
    slidesWrapper.addEventListener('touchmove', touchMove, { passive: true });
    slidesWrapper.addEventListener('touchend', touchEnd);
    slidesWrapper.addEventListener('mousedown', touchStart);
    slidesWrapper.addEventListener('mousemove', touchMove);
    slidesWrapper.addEventListener('mouseup', touchEnd);
    slidesWrapper.addEventListener('mouseleave', touchEnd);
  }

  // --- Detect and initialize based on screen width ---
  function checkDevice() {
    if (window.innerWidth <= 768) {
      enableMobile();
    } else {
      enableDesktop();
    }
  }

  // Run on load
  checkDevice();
  setPositionByIndex();

  // Run on resize
  window.addEventListener('resize', () => {
    checkDevice();
    setPositionByIndex();
  });

  // Prevent image dragging
  slidesWrapper.querySelectorAll('img').forEach(img => {
    img.addEventListener('dragstart', e => e.preventDefault());
  });
});

// Cursor blend mode

document.querySelectorAll('.slide img').forEach(img => {
  img.addEventListener('mouseenter', () => {
    document.querySelectorAll('.click-zone').forEach(zone => {
      zone.classList.add('blend-cursor');
    });
  });

  img.addEventListener('mouseleave', () => {
    document.querySelectorAll('.click-zone').forEach(zone => {
      zone.classList.remove('blend-cursor');
    });
  });
});