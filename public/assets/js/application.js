document.addEventListener('DOMContentLoaded', () => {
  const programSelect = document.getElementById('programSelect');
  const programOtherWrap = document.getElementById('programOtherWrap');

  if (!programSelect || !programOtherWrap) return;

  const toggleOther = () => {
    if (programSelect.value === '__OTHER__') {
      programOtherWrap.classList.remove('hidden');
    } else {
      programOtherWrap.classList.add('hidden');
    }
  };

  programSelect.addEventListener('change', toggleOther);
  toggleOther();
});