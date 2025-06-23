

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>User Profile</h1>
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>" id="biodata-tab"
                    href="<?php echo e(route('profile')); ?>" role="tab">Biodata</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('academic_records.index') ? 'active' : ''); ?>" id="academic-tab"
                    href="<?php echo e(route('academic_records.index')); ?>" role="tab">Academic
                    Records</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('professional_qualifications.index') ? 'active' : ''); ?>"
                    id="qualifications-tab" href="<?php echo e(route('professional_qualifications.index')); ?>" role="tab">Professional
                    Qualifications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('professional_memberships.index') ? 'active' : ''); ?>"
                    id="bodies-tab" href="<?php echo e(route('professional_memberships.index')); ?>" role="tab">Professional Membership</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('employment_history.index') ? 'active' : ''); ?>" id="employment-tab"
                    href="<?php echo e(route('employment_history.index')); ?>" role="tab">Employment
                    History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->routeIs('referees.index') ? 'active' : ''); ?>" id="referees-tab"
                    href="<?php echo e(route('referees.index')); ?>" role="tab">Referees</a>
            </li>
        </ul>

        <div class="card mb-4">
            <div class="card-body">
                <a href="<?php echo e(route('professional_qualifications.create')); ?>" class="btn btn-primary mb-3">Add New</a>


                <?php if($qualifications->isEmpty()): ?>
                    <p>No professional qualifications found.</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
    <tr>
        <th>Level</th>
        <th>Description</th>
        <th>File</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>


<tbody>
    <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($qualification->levelDescription()); ?></td>
            <td><?php echo e($qualification->description); ?></td>
            <td>
                <a href="<?php echo e(route('files.professional_qualification.view', $qualification->id)); ?>" target="_blank" class="btn btn-info btn-sm">View</a>
                <a href="<?php echo e(route('files.professional_qualification.download', $qualification->id)); ?>" class="btn btn-success btn-sm">Download</a>
            </td>
          

<td>
    <a href="<?php echo e(route('professional_qualifications.edit', $qualification->id)); ?>"
                                            class="btn btn-warning btn-sm">Edit</a>

    <form action="<?php echo e(route('professional_qualifications.destroy', $qualification->id)); ?>"
          method="POST" style="display:inline;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this qualification?')">
            Delete
        </button>
    </form>
</td>

        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>

                        
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\orpp4\resources\views/user/professional_qualifications/index.blade.php ENDPATH**/ ?>