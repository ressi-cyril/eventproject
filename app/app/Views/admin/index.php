<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="row">
            <!-- Pages Section -->
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card mb-3 w-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Pages</h5>
                        <p class="card-text flex-grow-1">Manage website pages and their content.</p>
                        <a href="<?= base_url('admin/pages') ?>" class="btn btn-primary mt-auto">Go to Pages</a>
                    </div>
                </div>
            </div>
            <!-- Events Section -->
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card mb-3 w-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Events</h5>
                        <p class="card-text flex-grow-1">Manage main event details and organizer info.</p>
                        <a href="<?= base_url('admin/events') ?>" class="btn btn-primary mt-auto">Go to Events</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
