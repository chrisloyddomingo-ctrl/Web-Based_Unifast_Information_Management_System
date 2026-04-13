document.addEventListener("DOMContentLoaded", () => {
  const programSelect = document.getElementById("programSelect");
  const programOtherWrap = document.getElementById("programOtherWrap");
  const programOther = document.getElementById("programOther");

  // If page doesn't have program section, do nothing
  if (!programSelect || !programOtherWrap || !programOther) return;

  function toggleOtherProgram() {
    const isOther = programSelect.value === "__OTHER__";

    // show/hide
    programOtherWrap.classList.toggle("hidden", !isOther);

    // required only when Other is selected
    programOther.required = isOther;

    // disable & clear when not Other (prevents stale value being submitted)
    programOther.disabled = !isOther;
    if (!isOther) programOther.value = "";
  }

  programSelect.addEventListener("change", toggleOtherProgram);
  toggleOtherProgram();
});