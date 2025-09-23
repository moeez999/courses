import elements from "../common/Elements.js";

function OutlineStarFillOnHoverAndSelect(stars) {
  let selectedRating = 0; // Track permanent selection

  stars.forEach((star, index) => {
    // Mouseover event - temporary hover effect
    star.addEventListener("mouseover", () => {
      clearAllStars();
      fillStarsUpTo(index + 1);
    });

    // Click event - permanent selection
    star.addEventListener("click", () => {
      selectedRating = index + 1;
      clearAllStars();
      fillStarsUpTo(selectedRating);

      console.log(`Selected rating: ${selectedRating} stars`);
    });
  });

  // Restore selected rating when mouse leaves the container
  const starContainer = stars[0].parentElement;
  starContainer.addEventListener("mouseleave", () => {
    clearAllStars();
    if (selectedRating > 0) {
      fillStarsUpTo(selectedRating);
    }
  });

  // Helper function: Fill stars up to count
  function fillStarsUpTo(count) {
    for (let i = 0; i < count && i < stars.length; i++) {
      stars[i].classList.add("active");
    }
  }

  // Helper function: Clear all stars
  function clearAllStars() {
    stars.forEach((star) => {
      star.classList.remove("active");
    });
  }

  // Public methods
  function setRating(rating) {
    if (rating >= 0 && rating <= stars.length) {
      selectedRating = rating;
      clearAllStars();
      if (rating > 0) {
        fillStarsUpTo(rating);
      }
    }
  }

  function getRating() {
    return selectedRating;
  }

  function resetRating() {
    selectedRating = 0;
    clearAllStars();
  }

  return {
    setRating,
    getRating,
    resetRating,
  };
}

// Init multiple star rating groupsF
function InitStarRatings() {
  const ratingOne = OutlineStarFillOnHoverAndSelect(elements.outlineAndFillStarOne);
  const ratingTwo = OutlineStarFillOnHoverAndSelect(elements.outlineAndFillStarTwo);

  // example: agar programmatically set karna ho
  // ratingOne.setRating(3);
  // console.log(ratingTwo.getRating());
}

export { InitStarRatings, OutlineStarFillOnHoverAndSelect };
