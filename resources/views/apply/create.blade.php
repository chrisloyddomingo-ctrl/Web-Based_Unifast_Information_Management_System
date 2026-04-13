<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Grantees Application</title>

  <link rel="stylesheet" href="{{ asset('css/application.css') }}?v={{ time() }}" />
</head>
<body>
  <main class="wrap">

    <header class="header header-top">
      <div class="logos-left">
        <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU Logo" class="Ifsulogo">
        <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="UNIFAST Logo" class="Unifastlogo">
      </div>

      <h1 class="header-title">Grantees Application Form</h1>
    </header>

    {{-- SUCCESS + ERROR ALERTS --}}
    @if (session('success'))
      <div class="alert success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert error">
        Please fix the highlighted fields.
      </div>
    @endif

    <section class="card instructions">
      <div class="cardHead">
        <h2>Instructions</h2>
      </div>

      <ol class="instruction-list">
        <li>Fill out all required fields marked with <span class="req">*</span>.</li>
        <li>Make sure your Student ID and personal details match your official records.</li>
        <li>Select your program. If not listed, choose <b>Other</b> and specify your program.</li>
        <li>Double-check your contact information before submitting.</li>
        <li>Click <b>Submit</b> once finished. You will be redirected to a confirmation page.</li>
      </ol>
    </section>

    <form method="POST" action="{{ route('apply.store') }}" novalidate>
      @csrf

      <section class="card">
        <div class="cardHead">
          <h2>Student Information</h2><span class="step"></span>
        </div>

        <div class="row">
          <div class="col">
            <label>Student ID <span class="req">*</span></label>
            <input name="student_id" type="text" value="{{ old('student_id') }}" placeholder="e.g., 23-123456" />
            @error('student_id') <div class="error">{{ $message }}</div> @enderror
          </div>

          <div class="col">
            <label>Sex <span class="req">*</span></label>
            <select name="sex">
              <option value="">-- Select --</option>
              <option value="M" @selected(old('sex') === 'M')>Male</option>
              <option value="F" @selected(old('sex') === 'F')>Female</option>
            </select>
            @error('sex') <div class="error">{{ $message }}</div> @enderror
          </div>

          <div class="col">
            <label>Birthdate <span class="req">*</span></label>
            <input name="birthdate" type="date" value="{{ old('birthdate') }}" />
            @error('birthdate') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Last Name <span class="req">*</span></label>
            <input name="last_name" type="text" value="{{ old('last_name') }}" placeholder="Dela Cruz" />
            @error('last_name') <div class="error">{{ $message }}</div> @enderror
          </div>

          <div class="col">
            <label>Given Name <span class="req">*</span></label>
            <input name="given_name" type="text" value="{{ old('given_name') }}" placeholder="Juan" />
            @error('given_name') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Middle Name <span class="req">*</span></label>
            <input name="middle_name" type="text" value="{{ old('middle_name') }}" placeholder="Santos" />
            @error('middle_name') <div class="error">{{ $message }}</div> @enderror
          </div>

          <div class="col">
            <label>Ext. Name <span class="muted">(optional)</span></label>
            <input name="ext_name" type="text" value="{{ old('ext_name') }}" />
            @error('ext_name') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>
      </section>

      <section class="card">
        <div class="cardHead">
          <h2>Student Profile</h2><span class="step"></span>
        </div>

        <div class="row">
          <div class="col">
            <label>Complete Program Name <span class="req">*</span></label>

            <select name="program_name" id="programSelect">
              <option value="">-- Select Program --</option>
              <option value="BS Information Technology" @selected(old('program_name') === 'BS Information Technology')>BS Information Technology</option>
              <option value="ACT" @selected(old('program_name') === 'ACT')>ACT</option>
              <option value="BS Education" @selected(old('program_name') === 'BS Education')>BS Education</option>
              <option value="BS Criminology" @selected(old('program_name') === 'BS Criminology')>BS Criminology</option>
              <option value="BS Psychology" @selected(old('program_name') === 'BS Psychology')>BS Psychology</option>
              <option value="BS Political Science" @selected(old('program_name') === 'BS Political Science')>BS Political Science</option>
              <option value="BS Agriculture" @selected(old('program_name') === 'BS Agriculture')>BS Agriculture</option>
              <option value="__OTHER__" @selected(old('program_name') === '__OTHER__')>Other (Please specify)</option>
            </select>

            @error('program_name') <div class="error">{{ $message }}</div> @enderror

            <div id="programOtherWrap" class="{{ old('program_name') === '__OTHER__' ? '' : 'hidden' }}">
              <label class="mt10">Specify Program <span class="req">*</span></label>
              <input
                name="program_name_other"
                id="programOther"
                type="text"
                value="{{ old('program_name_other') }}"
                placeholder="Type your program/course"
                {{ old('program_name') === '__OTHER__' ? '' : 'disabled' }}
              />
              @error('program_name_other') <div class="error">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="col">
            <label>Year Level <span class="req">*</span></label>
            <select name="year_level">
              <option value="">-- Select Year Level --</option>
              <option value="1st Year" @selected(old('year_level') === '1st Year')>1st Year</option>
              <option value="2nd Year" @selected(old('year_level') === '2nd Year')>2nd Year</option>
              <option value="3rd Year" @selected(old('year_level') === '3rd Year')>3rd Year</option>
              <option value="4th Year" @selected(old('year_level') === '4th Year')>4th Year</option>
              <option value="Irregular" @selected(old('year_level') === 'Irregular')>Irregular</option>
            </select>
            @error('year_level') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Are you a First Generation College Student? <span class="req">*</span></label>

            <div style="margin-top: 8px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
              <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                <input
                  type="radio"
                  name="first_generation"
                  value="1"
                  {{ old('first_generation') === '1' ? 'checked' : '' }}
                  required
                >
                <span>Yes</span>
              </label>

              <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                <input
                  type="radio"
                  name="first_generation"
                  value="0"
                  {{ old('first_generation') === '0' ? 'checked' : '' }}
                >
                <span>No</span>
              </label>
            </div>

            <small class="muted">Select Yes if neither of your parents attended college.</small>

            @error('first_generation')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>

          <div class="col">
            <label>Parents Monthly Income <span class="req">*</span></label>

            <select name="parents_monthly_income" required>
              <option value="">-- Select Income Range --</option>
              <option value="below_5000" {{ old('parents_monthly_income') === 'below_5000' ? 'selected' : '' }}>Below ₱5,000</option>
              <option value="5000_10000" {{ old('parents_monthly_income') === '5000_10000' ? 'selected' : '' }}>₱5,000 – ₱10,000</option>
              <option value="10000_20000" {{ old('parents_monthly_income') === '10000_20000' ? 'selected' : '' }}>₱10,000 – ₱20,000</option>
              <option value="20000_40000" {{ old('parents_monthly_income') === '20000_40000' ? 'selected' : '' }}>₱20,000 – ₱40,000</option>
              <option value="above_40000" {{ old('parents_monthly_income') === 'above_40000' ? 'selected' : '' }}>Above ₱40,000</option>
            </select>

            @error('parents_monthly_income')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </section>

      <section class="card">
        <div class="cardHead">
          <h2>Father's Name</h2><span class="step"></span>
        </div>

        <div class="row">
          <div class="col">
            <label>Last Name <span class="req">*</span></label>
            <input name="father_last_name" type="text" value="{{ old('father_last_name') }}" placeholder="Dela Cruz" />
            @error('father_last_name') <div class="error">{{ $message }}</div> @enderror
          </div>
          <div class="col">
            <label>Given Name <span class="req">*</span></label>
            <input name="father_given_name" type="text" value="{{ old('father_given_name') }}" placeholder="Juanito" />
            @error('father_given_name') <div class="error">{{ $message }}</div> @enderror
          </div>
          <div class="col">
            <label>Middle Name <span class="req">*</span></label>
            <input name="father_middle_name" type="text" value="{{ old('father_middle_name') }}" placeholder="Perez" />
            @error('father_middle_name') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>
      </section>

      <section class="card">
        <div class="cardHead">
          <h2>Mother's Maiden Name</h2>
        </div>

        <div class="row">
          <div class="col">
            <label>Last Name <span class="req">*</span></label>
            <input name="mother_last_name" type="text" value="{{ old('mother_last_name') }}" placeholder="Santos" />
            @error('mother_last_name') <div class="error">{{ $message }}</div> @enderror
          </div>
          <div class="col">
            <label>Given Name <span class="req">*</span></label>
            <input name="mother_given_name" type="text" value="{{ old('mother_given_name') }}" placeholder="Maria" />
            @error('mother_given_name') <div class="error">{{ $message }}</div> @enderror
          </div>
          <div class="col">
            <label>Middle Name <span class="req">*</span></label>
            <input name="mother_middle_name" type="text" value="{{ old('mother_middle_name') }}" placeholder="Assuncion" />
            @error('mother_middle_name') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>
      </section>

      <section class="card">
        <div class="cardHead">
          <h2>Address & Contact</h2>
        </div>

        <label>Street, Barangay, Municipality, Province <span class="req">*</span></label>
        <input name="street_barangay" type="text" value="{{ old('street_barangay') }}" placeholder="Purok 2, Turod, Panopdopan, Lamut, Ifugao" />
        @error('street_barangay') <div class="error">{{ $message }}</div> @enderror

        <div class="row">
          <div class="col">
            <label>Zipcode <span class="req">*</span></label>
            <input name="zipcode" type="text" value="{{ old('zipcode') }}" placeholder="2600" />
            @error('zipcode') <div class="error">{{ $message }}</div> @enderror
          </div>
          <div class="col">
            <label>Contact Number <span class="req">*</span></label>
            <input name="contact_number" type="text" value="{{ old('contact_number') }}" placeholder="09123456789" />
            @error('contact_number') <div class="error">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Email Address <span class="req">*</span></label>
            <input name="email" type="text" value="{{ old('email') }}" placeholder="juandelacruz@gmail.com" />
            @error('email') <div class="error">{{ $message }}</div> @enderror
          </div>

          <div class="col">
            <label>Disability <span class="req">*</span></label>

            <select name="disability" id="disabilitySelect" required>
              <option value="">-- Select Disability --</option>
              <option value="N/A" {{ old('disability') === 'N/A' ? 'selected' : '' }}>N/A</option>
              <option value="Visual Impairment" {{ old('disability') === 'Visual Impairment' ? 'selected' : '' }}>Visual Impairment</option>
              <option value="Hearing Impairment" {{ old('disability') === 'Hearing Impairment' ? 'selected' : '' }}>Hearing Impairment</option>
              <option value="Speech Impairment" {{ old('disability') === 'Speech Impairment' ? 'selected' : '' }}>Speech Impairment</option>
              <option value="Orthopedic Disability" {{ old('disability') === 'Orthopedic Disability' ? 'selected' : '' }}>Orthopedic Disability</option>
              <option value="Learning Disability" {{ old('disability') === 'Learning Disability' ? 'selected' : '' }}>Learning Disability</option>
              <option value="Psychosocial Disability" {{ old('disability') === 'Psychosocial Disability' ? 'selected' : '' }}>Psychosocial Disability</option>
              <option value="Other" {{ old('disability') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>

            @error('disability')
              <div class="error">{{ $message }}</div>
            @enderror

            <div id="disabilityOtherWrap" class="{{ old('disability') === 'Other' ? '' : 'hidden' }}">
              <label class="mt10">Please specify disability <span class="req">*</span></label>
              <input
                type="text"
                name="disability_other"
                id="disabilityOther"
                value="{{ old('disability_other') }}"
                placeholder="Type disability here"
                {{ old('disability') === 'Other' ? '' : 'disabled' }}
              />
              @error('disability_other')
                <div class="error">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <label>Indigenous People Group <span class="muted">(optional)</span></label>
        <input name="indigenous_group" type="text" value="{{ old('indigenous_group') }}" />
        @error('indigenous_group') <div class="error">{{ $message }}</div> @enderror

        <div class="actions">
          <button type="reset" class="btn secondary">Clear</button>
          <button type="submit" class="btn">Submit</button>
        </div>
      </section>
    </form>

    <footer class="footer">
      <small>© Web-Based UniFAST Management System</small>
    </footer>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const programSelect = document.getElementById("programSelect");
      const programOtherWrap = document.getElementById("programOtherWrap");
      const programOther = document.getElementById("programOther");

      const disabilitySelect = document.getElementById("disabilitySelect");
      const disabilityOtherWrap = document.getElementById("disabilityOtherWrap");
      const disabilityOther = document.getElementById("disabilityOther");

      function toggleOtherProgram() {
        if (!programSelect || !programOtherWrap || !programOther) return;

        const isOther = programSelect.value === "__OTHER__";
        programOtherWrap.classList.toggle("hidden", !isOther);
        programOther.required = isOther;
        programOther.disabled = !isOther;

        if (!isOther) {
          programOther.value = "";
        }
      }

      function toggleOtherDisability() {
        if (!disabilitySelect || !disabilityOtherWrap || !disabilityOther) return;

        const isOther = disabilitySelect.value === "Other";
        disabilityOtherWrap.classList.toggle("hidden", !isOther);
        disabilityOther.required = isOther;
        disabilityOther.disabled = !isOther;

        if (!isOther) {
          disabilityOther.value = "";
        }
      }

      if (programSelect) {
        programSelect.addEventListener("change", toggleOtherProgram);
        toggleOtherProgram();
      }

      if (disabilitySelect) {
        disabilitySelect.addEventListener("change", toggleOtherDisability);
        toggleOtherDisability();
      }
    });
  </script>
</body>
</html>