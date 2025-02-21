<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Pages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Pages</h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <a href="/admin/pages/create" class="btn btn-primary mb-3">Add New Page</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Sous-titre</th>
                    <th>Type de Page</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?= esc($page['id']) ?></td>
                        <td><?= esc($page['title']) ?></td>
                        <td><?= esc($page['subtitle']) ?></td>
                        <td><?= esc($page['page_type']) ?></td>
                        <td>
                            <a href="/admin/pages/edit/<?= $page['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/admin/pages/delete/<?= $page['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
