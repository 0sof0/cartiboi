<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-step');
    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
        
        progressSteps.forEach((step, index) => {
            step.classList.toggle('active', index <= stepIndex);
        });
    }

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-next')) {
            currentStep++;
            if (currentStep >= steps.length) {
                document.querySelector('.form-container').style.display = 'none';
                document.querySelector('.confirmation-page').classList.add('active');
            } else {
                showStep(currentStep);
            }
        }
        
        if (e.target.classList.contains('btn-prev')) {
            currentStep = Math.max(0, currentStep - 1);
            showStep(currentStep);
        }
    });
});
    </script>
</head>
<body>
    <h2>Add New Product</h2>
    <div class="form-container">
    <div class="progress-bar">
        <div class="progress-step active">1</div>
        <div class="progress-step">2</div>
        <div class="progress-step">3</div>
        <div class="progress-step">4</div>
    </div>

    <!-- Step 1 -->
    <div class="form-step active" data-step="1">
        <!-- Your form fields for step 1 -->
        <div class="form-navigation">
            <button type="button" class="btn-nav btn-next">Next</button>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="form-step" data-step="2">
        <!-- Your form fields for step 2 -->
        <div class="form-navigation">
            <button type="button" class="btn-nav btn-prev">Previous</button>
            <button type="button" class="btn-nav btn-next">Next</button>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="form-step" data-step="3">
        <!-- Your form fields for step 3 -->
        <div class="form-navigation">
            <button type="button" class="btn-nav btn-prev">Previous</button>
            <button type="button" class="btn-nav btn-next">Next</button>
        </div>
    </div>

    <!-- Confirmation Page -->
    <div class="confirmation-page">
        <div class="confirmation-icon">✓</div>
        <h2 class="confirmation-message">Form Submitted Successfully!</h2>
        <p>Thank you for your submission.</p>
    </div>
</div>
</body>
</html>

