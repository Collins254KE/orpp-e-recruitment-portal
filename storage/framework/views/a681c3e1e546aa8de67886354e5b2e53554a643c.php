

<?php $__env->startSection('content'); ?>
    <h1>Job Listings</h1>
    
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Job Listings</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.job-listings.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label for="min_level" class="form-label">Minimum Qualification Level</label>
                    <select name="min_level" id="min_level" class="form-control">
                        <option value="">All Levels</option>
                        <option value="1" <?php echo e($filters['min_level'] == '1' ? 'selected' : ''); ?>>Certificate</option>
                        <option value="2" <?php echo e($filters['min_level'] == '2' ? 'selected' : ''); ?>>Diploma</option>
                        <option value="3" <?php echo e($filters['min_level'] == '3' ? 'selected' : ''); ?>>Degree</option>
                        <option value="4" <?php echo e($filters['min_level'] == '4' ? 'selected' : ''); ?>>Master</option>
                        <option value="5" <?php echo e($filters['min_level'] == '5' ? 'selected' : ''); ?>>PhD</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="min_years_of_experience" class="form-label">Min Years Experience</label>
                    <input type="number" name="min_years_of_experience" id="min_years_of_experience" 
                           class="form-control" min="0" max="50" 
                           value="<?php echo e($filters['min_years_of_experience'] ?? ''); ?>" 
                           placeholder="Any">
                </div>
                <div class="col-md-3">
                    <label for="is_published" class="form-label">Published Status</label>
                    <select name="is_published" id="is_published" class="form-control">
                        <option value="">All</option>
                        <option value="1" <?php echo e($filters['is_published'] == '1' ? 'selected' : ''); ?>>Published</option>
                        <option value="0" <?php echo e($filters['is_published'] == '0' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>
             <div class="col-md-3 d-flex align-items-end">
    <button type="submit" class="btn btn-primary me-2">Filter</button>

    <a href="<?php echo e(route('admin.job-listings.index')); ?>" class="btn btn-secondary me-2">Clear</a>

    <form action="<?php echo e(route('admin.applications.report')); ?>" method="GET" target="_blank">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-chart-pie"></i> Report
        </button>
    </form>
</div>

    </div>

    <a href="<?php echo e(route('admin.job-listings.create')); ?>" class="btn btn-primary mb-3">Add New Job Listing</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Location</th>
                <th>Deadline</th>
                <th>Min Level</th>
                <th>Min Experience</th>
                <th>Applicants</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $jobListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobListing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($jobListing->title); ?></td>
                    <td><?php echo e($jobListing->location); ?></td>
                    <td><?php echo e($jobListing->deadline); ?></td>
                    <td>
                        <?php if($jobListing->min_level): ?>
                            <?php switch($jobListing->min_level):
                                case (1): ?> Certificate <?php break; ?>
                                <?php case (2): ?> Diploma <?php break; ?>
                                <?php case (3): ?> Degree <?php break; ?>
                                <?php case (4): ?> Master <?php break; ?>
                                <?php case (5): ?> PhD <?php break; ?>
                                <?php default: ?> Unknown
                            <?php endswitch; ?>
                        <?php else: ?>
                            <span class="text-muted">Any</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($jobListing->min_years_of_experience): ?>
                            <?php echo e($jobListing->min_years_of_experience); ?> years
                        <?php else: ?>
                            <span class="text-muted">Any</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($jobListing->applications?->count() ?? 0); ?></td>
                    <td><?php echo e($jobListing->is_published == 1? 'Yes': 'No'); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.job-listings.edit', $jobListing->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?php echo e(route('admin.applications.index', ['job_id' => $jobListing->id])); ?>" class="btn btn-info btn-sm">View Applications</a>
                        <a href="<?php echo e(route('admin.applications.export', ['job_id' => $jobListing->id])); ?>" class="btn btn-success btn-sm">Export Applicants</a>
                        <form action="<?php echo e(route('admin.job-listings.destroy', $jobListing->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job listing?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\orpp4\resources\views/admin/job-listings/index.blade.php ENDPATH**/ ?>