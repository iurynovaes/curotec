<!-- Modal -->
<div class="modal fade" id="jobApplicationModal" tabindex="-1" aria-labelledby="jobApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="multiStepForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobApplicationModalLabel">Job Application - <span id="job_title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <input type="hidden" id="job_id" name="job_id">
                <input type="hidden" name="user_id" value="1">

                <div class="modal-body">
                    <!-- Step Indicators -->
                    <ul class="nav nav-pills mb-3" id="stepIndicators">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" data-step="0">Personal Info</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" data-step="1">Experience</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" data-step="2">Upload</button>
                        </li>
                    </ul>

                    <!-- Step 1 -->
                    <div class="step" data-step="0">
                        <div class="mb-3 form-group">
                            <label>Name</label>
                            <input name="name" class="form-control" maxlength="50" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" placeholder="test@example.com" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Phone</label>
                            <input name="phone" class="form-control" maxlength="14" placeholder="(123) 456-7890" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step d-none" data-step="1">
                        <div class="mb-3 form-group">
                            <label>Last Position</label>
                            <input name="last_position" class="form-control" placeholder="Software Developer" maxlength="50" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Experience Years</label>
                            <input name="experience_years" type="number" class="form-control" min="1"  max="50" value="1" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Experience Level</label>
                            <select name="experience_level" class="form-select" required>
                                <option value="">Choose...</option>
                                @foreach($experienceLevels as $level)
                                    <option value="{{ $level->value }}">
                                        {{ ucfirst($level->value) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step d-none" data-step="2">
                        <div class="mb-3 form-group">
                            <label>Resume (PDF)</label>
                            <input type="file" name="resume" class="form-control" accept="application/pdf" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Cover Letter (PDF)</label>
                            <input type="file" name="cover_letter" class="form-control" accept="application/pdf">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div id="formErrors" class="text-danger mt-2"></div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" id="prevBtn" class="btn btn-secondary d-none">Previous</button>
                        <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-success d-none">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', () => {
		let currentStep = 0;
		const steps = document.querySelectorAll('.step');
		const indicators = document.querySelectorAll('#stepIndicators button');
		const prevBtn = document.getElementById('prevBtn');
		const nextBtn = document.getElementById('nextBtn');
		const submitBtn = document.getElementById('submitBtn');
		const form = document.getElementById('multiStepForm');
		const errorsDiv = document.getElementById('formErrors');

		const showStep = (index) => {
			steps.forEach((step, i) => {
				step.classList.toggle('d-none', i !== index);
				indicators[i].classList.toggle('active', i === index);
			});
			prevBtn.classList.toggle('d-none', index === 0);
			nextBtn.classList.toggle('d-none', index === steps.length - 1);
			submitBtn.classList.toggle('d-none', index !== steps.length - 1);
		};

		const validateField = (input) => {

			const value = input.value.trim();
			let error = '';

			if (input.required && !value) {
				error = 'This field is required.';
			} else if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
				error = 'Please enter a valid email. Example: test@example.com';
			}

			if (error) {
				input.classList.add('is-invalid');
				input.nextElementSibling.textContent = error;
			} else {
				input.classList.remove('is-invalid');
				input.nextElementSibling.textContent = '';
			}

			return !error;
		};

		const validateStep = (index) => {

			let valid = true;

			const inputs = steps[index].querySelectorAll('input, select');

			for (let input of inputs) {
				const result = validateField(input);
				if (!result) valid = false;
			}

			return valid;
		};

		nextBtn.addEventListener('click', () => {
			if (validateStep(currentStep)) {
				currentStep++;
				showStep(currentStep);
			}
		});

		prevBtn.addEventListener('click', () => {
			currentStep--;
			showStep(currentStep);
		});

		indicators.forEach((btn, i) => {
			btn.addEventListener('click', () => {
				if (i <= currentStep) {
					currentStep = i;
					showStep(currentStep);
				}
			});
		});

		form.addEventListener('submit', async (e) => {
			e.preventDefault();
			if (!validateStep(currentStep)) return;

			let jobId = document.getElementById('job_id').value;

			const formData = new FormData(form);
			errorsDiv.innerHTML = '';

			try {
				const res = await fetch(`/api/jobs/${jobId}/apply`, { 
					method: 'POST', 
					body: formData,
					headers: {
						'X-API-TOKEN': _globalApiToken
					} 
				});
				
				const data = await res.json();

				if (!res.ok) {
					const msg = Object.values(data.errors || {}).flat().join('<br>');
					errorsDiv.innerHTML = msg || 'Something went wrong.';
				} else {
					alert(data.message);
					form.reset();
					currentStep = 0;
					showStep(0);
					const modal = bootstrap.Modal.getInstance(document.getElementById('jobApplicationModal'));
					modal.hide();
				}
			} catch (err) {
				console.error(err);
				errorsDiv.innerHTML = 'Failed to submit the application.';
			}
		});

		showStep(currentStep);
	});
</script>
@endpush