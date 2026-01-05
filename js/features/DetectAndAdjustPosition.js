function DetectAndAdjustPosition(elementGetPosition, modalToSetPosition) {
  const rect = elementGetPosition.getBoundingClientRect();

  let left = rect.left + window.scrollX;
  let top = rect.bottom + window.scrollY;

  const modalRect = modalToSetPosition.getBoundingClientRect();
  const modalWidth = modalRect.width;
  const modalHeight = modalRect.height;

  const viewportWidth = window.innerWidth;
  const viewportHeight = window.innerHeight;

  // Right boundary check
  if (left + modalWidth > viewportWidth) {
    left = viewportWidth - modalWidth - 24;
  }

  // Left boundary check
  if (left < 0) {
    left = 10;
  }

  // Bottom boundary check
  if (top + modalHeight > viewportHeight + window.scrollY) {
    top = rect.top + window.scrollY - modalHeight;
  }

  modalToSetPosition.style.top = `${top}px`;
  modalToSetPosition.style.left = `${left}px`;
}

export default DetectAndAdjustPosition;