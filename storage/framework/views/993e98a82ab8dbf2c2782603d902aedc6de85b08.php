<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Roles Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        h1 {
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Roles Report</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Role</th>
                <th>Description</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($role->id); ?></td>
                    <td><?php echo e($role->name); ?></td>
                    <td><?php echo e($role->description ?? ' '); ?></td>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/role/pdf.blade.php ENDPATH**/ ?>