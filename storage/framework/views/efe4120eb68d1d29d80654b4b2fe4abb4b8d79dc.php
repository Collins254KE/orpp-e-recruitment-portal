

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Edit Biodata</h1>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the errors below:
            <ul class="mt-2 mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('profile.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>">
        </div>

        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <select name="title" class="form-control">
                <option value="">Select Title</option>
                <?php $__currentLoopData = ['Mr', 'Mrs', 'Miss', 'Dr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($title); ?>" <?php echo e(old('title', $user->title) == $title ? 'selected' : ''); ?>><?php echo e($title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <div class="mb-3">
            <label for="id_passport" class="form-label">ID/Passport</label>
            <input type="text" name="id_passport" class="form-control" value="<?php echo e(old('id_passport', $user->id_passport)); ?>">
        </div>

        
        <div class="mb-3">
            <label for="kra_pin" class="form-label">KRA PIN</label>
            <input type="text" name="kra_pin" class="form-control" value="<?php echo e(old('kra_pin', $user->kra_pin)); ?>">
        </div>

        
        <div class="mb-3">
            <label for="county" class="form-label">County</label>
            <select name="county" id="county" class="form-control" onchange="loadSubCounties()">
                <option value="">Select County</option>
                <?php
                    $counties = [
                        "Mombasa", "Kwale", "Kilifi", "Tana River", "Lamu", "Taita-Taveta", "Garissa", "Wajir", "Mandera",
                        "Marsabit", "Isiolo", "Meru", "Tharaka-Nithi", "Embu", "Kitui", "Machakos", "Makueni", "Nyandarua",
                        "Nyeri", "Kirinyaga", "Murang'a", "Kiambu", "Turkana", "West Pokot", "Samburu", "Trans Nzoia",
                        "Uasin Gishu", "Elgeyo-Marakwet", "Nandi", "Baringo", "Laikipia", "Nakuru", "Narok", "Kajiado",
                        "Kericho", "Bomet", "Kakamega", "Vihiga", "Bungoma", "Busia", "Siaya", "Kisumu", "Homa Bay",
                        "Migori", "Kisii", "Nyamira", "Nairobi"
                    ];
                ?>
                <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($county); ?>" <?php echo e(old('county', $user->county) == $county ? 'selected' : ''); ?>><?php echo e($county); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        

<div class="mb-3">
    <label for="sub_county" class="form-label">Sub-County</label>
    <select name="sub_county" id="sub_county" class="form-control">
        <option value="">Select Sub-County</option>
        
    </select>
</div>

<div class="mb-3">
    <label for="ethnicity" class="form-label text-sm fw-medium text-dark">Ethnicity</label>
    <select name="ethnicity" id="ethnicity" class="form-select">
        <option value="" disabled selected>Select Ethnicity</option>
        <option value="Kikuyu">Kikuyu</option>
        <option value="Luhya">Luhya</option>
        <option value="Luo">Luo</option>
        <option value="Kalenjin">Kalenjin</option>
        <option value="Kamba">Kamba</option>    
        <option value="Somali">Somali</option>
        <option value="Kisii">Kisii</option>
        <option value="Mijikenda">Mijikenda</option>
        <option value="Meru">Meru</option>
        <option value="Turkana">Turkana</option>
        <option value="Maasai">Maasai</option>
        <option value="Embu">Embu</option>
        <option value="Taita">Taita</option>
        <option value="Taveta">Taveta</option>
        <option value="Samburu">Samburu</option>
        <option value="Pokot">Pokot</option>
        <option value="Boran">Boran</option>
        <option value="Rendille">Rendille</option>
        <option value="Swahili">Swahili</option>
        <option value="Other">Other</option>
    </select>
</div>

        
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select Gender</option>
                <?php $__currentLoopData = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e(old('gender', $user->gender) == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" name="nationality" class="form-control" value="<?php echo e(old('nationality', $user->nationality)); ?>">
        </div>

        
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="<?php echo e(old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '')); ?>">
        </div>

<div class="mb-3">
    <label for="disability_status" class="form-label">Do you have a disability?</label>
    <select name="disability_status" id="disability_status" class="form-control">
        <option value="">Select Option</option>
        <option value="yes" <?php echo e(old('disability_status', $user->disability_status) == 'yes' ? 'selected' : ''); ?>>Yes</option>
        <option value="no" <?php echo e(old('disability_status', $user->disability_status) == 'no' ? 'selected' : ''); ?>>No</option>
    </select>
</div>


<div class="mb-3" id="certificateField" style="display: none;">
    <label for="disability_certificate_number" class="form-label">Disability Certificate Number</label>
    <input type="text" name="disability_certificate_number" id="disability_certificate_number" class="form-control"
        value="<?php echo e(old('disability_certificate_number', $user->disability_certificate_number)); ?>"
        placeholder="Enter certificate number if applicable">
</div>





        
        <button type="submit" class="btn btn-primary">Update Biodata</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<script>
    const countiesWithSubCounties = {
        "Mombasa": ["Changamwe", "Jomvu", "Kisauni", "Nyali", "Likoni", "Mvita"],
  "Kwale": ["Kinango", "Lunga Lunga", "Matuga", "Msambweni", "Kaloleni"],
  "Kilifi": ["Kilifi North", "Kilifi South", "Rabai", "Malindi", "Ganze", "Magarini"],
  "Tana River": ["Galole", "Garsen", "Bura"],
  "Lamu": ["Lamu East", "Lamu West"],
  "Taita-Taveta": ["Mwatate", "Voi", "Wundanyi"],
  "Garissa": ["Balambala", "Dadaab", "Fafi", "Garissa Township", "Ijara", "Lagdera"],
  "Wajir": ["Eldas", "Tarba", "Wajir East", "Wajir North", "Wajir South", "Wajir West", "Habaswein"],
  "Mandera": ["Banissa", "Mandera East", "Mandera North", "Mandera South", "Mandera West", "Lafey"],
  "Marsabit": ["North Horr", "Saku", "Laisamis", "Moyale"],
  "Isiolo": ["Isiolo North", "Isiolo South"],
  "Meru": ["Imenti North",'Imenti Central', "Imenti South", "Igembe Central", "Igembe North", "Igembe South", "Tigania East", "Tigania West"],
  "Tharaka-Nithi": ["Chuka", "Maara", "Tharaka"],
  "Embu": ["Runyenjes", "Manyatta", "Mbeere North", "Mbeere South"],
  "Kitui": ["Kitui Central", "Kitui East", "Kitui Rural", "Kitui South", "Kitui West", "Mwingi Central", "Mwingi North", "Mwingi West"],
  "Machakos": ["Machakos Town", "Mwala", "Yatta", "Mavoko", "Kangundo", "Kathiani", "Matungulu"],
  "Makueni": ["Kaiti", "Kilome", "Makueni", "Mbooni", "Kibwezi East", "Kibwezi West"],
  "Nyandarua": ["Kinangop", "Kipipiri", "Ndaragwa", "Ol Kalou", "Njabini"],
  "Nyeri": ["Tetu", "Mathira", "Kieni", "Othaya", "Nyeri Town"],
  "Kirinyaga": ["Gichugu", "Kirinyaga Central", "Kirinyaga East", "Mwea", "Ndia"],
  "Murang'a": ["Kiharu", "Kigumo", "Mathioya", "Kandara", "Maragwa", "Kigumo"],
  "Kiambu": ["Gatundu North", "Gatundu South", "Juja", "Kiambu", "Lari", "Thika East", "Thika West", "Ruiru", "Kabete", "Kiambaa"],
  "Turkana": ["Turkana Central", "Turkana East", "Turkana North", "Turkana South", "Turkana West", "Loima"],
  "West Pokot": ["Kacheliba", "Kapenguria", "Sigor", "Pokot South", "Tiaty"],
  "Samburu": ["Samburu East", "Samburu North", "Samburu West"],
  "Trans Nzoia": ["Cherangany", "Kwanza", "Saboti", "Endebess"],
  "Uasin Gishu": ["Eldoret East", "Eldoret West", "Soy", "Moiben", "Turbo"],
  "Elgeyo-Marakwet": ["Keiyo North", "Keiyo South", "Marakwet East", "Marakwet West"],
  "Nandi": ["Aldai", "Chesumei", "Emgwen", "Mosop", "Tinderet"],
  "Baringo": ["Baringo Central", "Baringo North", "Baringo South", "Mogotio", "Tiaty", "Eldama Ravine"],
  "Laikipia": ["Laikipia East", "Laikipia North", "Laikipia West"],
  "Nakuru": ["Nakuru Town East", "Nakuru Town West", "Gilgil", "Naivasha", "Molo", "Kuresoi North", "Kuresoi South", "Rongai", "Subukia", "Bahati", "Njoro"],
  "Narok": ["Narok East", "Narok North", "Narok South", "Emurua Dikirr", "Kilgoris", "Loita"],
  "Kajiado": ["Kajiado Central", "Kajiado North", "Kajiado South", "Kajiado East", "Kajiado West", "Ngong"],
  "Kericho": ["Bureti", "Ainamoi", "Kipkelion East", "Kipkelion West", "Sigowet-Soin"],
  "Bomet": ["Bomet Central", "Chepalungu", "Sotik","Konoin", "Bomet East"],
  "Kakamega": ["Lugari", "Likuyani", "Malava", "Matungu", "Butere", "Shinyalu", "Ikolomani", "Mumias East", "Mumias West", "Navakholo"],
  "Vihiga": ["Emuhaya", "Luanda", "Sabatia", "Vihiga", "Hamisi"],
  "Bungoma": ["Bungoma East", "Bungoma North", "Bungoma South", "Bungoma West", "Mt. Elgon", "Kimilili", "Webuye East", "Webuye West"],
  "Busia": ["Nambale", "Matayos", "Budalang'i", "Butula", "Funyula", "Teso North", "Teso South"],
  "Siaya": ["Gem", "Ugenya", "Rarieda", "Bondo", "Alego Usonga"],
  "Kisumu": ["Kisumu East", "Kisumu West", "Kisumu Central", "Seme", "Nyando", "Muhoroni", "Nyakach"],
  "Homa Bay": ["Homa Bay Town", "Ndhiwa", "Rachuonyo North", "Rachuonyo South", "Suba North", "Suba South", "Kabondo Kasipul"],
  "Migori": ["Suna East", "Suna West", "Rongo", "Awendo", "Nyatike", "Uriri", "Kuria West", "Kuria East"],
  "Kisii": ["Bonchari", "Kitutu Chache", "Nyaribari Chache", "Nyaribari Masaba", "South Mugirango", "Kitutu Masaba", "Marani"],
  "Nyamira": ["Borabu", "Nyamira", "West Mugirango"],
  "Nairobi": ["Westlands",
    "Kibra",
    "Lang'ata",
    "Dagoretti North",
    "Dagoretti South",
    "Embakasi Central",
    "Embakasi East",
    "Embakasi North",
    "Embakasi South",
    "Embakasi West",
    "Roysambu",
    "Kasarani",
    "Makadara",
    "Starehe",
    "Kamukunji",
    "Mathare",
    "Ruaraka"]
}

    function loadSubCounties() {
        const county = document.getElementById("county").value;
        const subCountySelect = document.getElementById("sub_county");

        // Clear previous options
        subCountySelect.innerHTML = '<option value="">Select Sub-County</option>';

        if (county && countiesWithSubCounties[county]) {
            countiesWithSubCounties[county].forEach(sub => {
                const option = document.createElement("option");
                option.value = sub;
                option.text = sub;
                subCountySelect.appendChild(option);
            });
        }
    }

    // Prepopulate sub-counties if editing
    document.addEventListener("DOMContentLoaded", () => {
        const selectedCounty = document.getElementById("county").value;
        const selectedSubCounty = <?php echo json_encode(old('sub_county', $user->sub_county), 512) ?>;
        if (selectedCounty) {
            loadSubCounties();
            setTimeout(() => {
                document.getElementById("sub_county").value = selectedSubCounty;
            }, 100);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const disabilitySelect = document.getElementById('disability_status');
        const certField = document.getElementById('certificateField');
        const certInput = document.getElementById('disability_certificate_number');

        function toggleCertificateField() {
            if (disabilitySelect.value === 'yes') {
                certField.style.display = 'block';
                setTimeout(() => certInput.focus(), 300);
                certInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                certField.style.display = 'none';
                certInput.value = ''; // Optional: clear input when hidden
            }
        }

        disabilitySelect.addEventListener('change', toggleCertificateField);

        // Run on load in case form was pre-filled
        toggleCertificateField();
    });
</script>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\orpp4\resources\views/profile/edit.blade.php ENDPATH**/ ?>