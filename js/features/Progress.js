function SetProgress(percentage) {
  const circle = document.querySelector(".progress-ring__circle");
  const radius = circle.r.baseVal.value; // 20 (new radius)
  const circumference = 2 * Math.PI * radius; // 125.6

  circle.style.strokeDasharray = `${circumference} ${circumference}`;
  circle.style.strokeDashoffset = circumference;

  const offset = circumference - (percentage / 100) * circumference;
  circle.style.strokeDashoffset = offset;

  document.querySelector(".progress-text").textContent = `${percentage}%`;
}

export default SetProgress;
