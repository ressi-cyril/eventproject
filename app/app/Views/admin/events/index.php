<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Events</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Events</h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <a href="/admin/events/create" class="btn btn-primary mb-3">Add New Event</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>ShortUrl</th>
                    <th>Organizer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= esc($event['id']) ?></td>
                        <td><?= esc($event['name']) ?></td>
                        <td><?= esc($event['slug']) ?></td>
                        <td><?= esc($event['shorturl']) ?></td>
                        <td><?= esc($event['organizer_first_name'] . ' ' . $event['organizer_last_name']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/event-occurrences/by-event/' . $event['id']) ?>" class="btn btn-info"> Manage Occurrences </a>
                            <a href="/admin/events/edit/<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/admin/events/delete/<?= $event['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>