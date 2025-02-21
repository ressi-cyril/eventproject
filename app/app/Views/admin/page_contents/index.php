<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Blocs de Contenu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Blocs de Contenu pour la Page <?= esc($pageId) ?></h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <a href="/admin/page-contents/create/<?= $pageId ?>" class="btn btn-primary mb-3">Ajouter un nouveau bloc</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Texte</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contents)): ?>
                    <?php foreach ($contents as $content): ?>
                        <tr>
                            <td><?= esc($content['id']) ?></td>
                            <td><?= esc($content['content_text']) ?></td>
                            <td>
                                <?php if (!empty($content['content_image'])): ?>
                                    <img src="<?= base_url('uploads/page_contents/' . esc($content['content_image'])) ?>" alt="Content Image" width="100">
                                <?php else: ?>
                                    Pas d'image
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/page-contents/edit/<?= $content['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/admin/page-contents/delete/<?= $content['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Etes-vous sûr ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun bloc de contenu trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
