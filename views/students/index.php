<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- Toast Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php $msgs = [
        'created'  => ['✅ Student add SuccessFully!', 'success'],
        'updated'  => ['✏️ Student update SuccessFully!', 'info'],
        'deleted'  => ['🗑️ Student delete SuccessFully!', 'danger'],
        'notfound' => ['❌ Student Not Exist!', 'danger'],
    ]; ?>
    <?php [$text, $type] = $msgs[$_GET['msg']] ?? ['Done!', 'info']; ?>
    <div class="toast toast--<?= $type ?>"><?= $text ?></div>
<?php endif; ?>

<div class="page-header">
    <div>
        <h1 class="page-title">All Students</h1>
        <p class="page-sub"><?= count($students) ?> students enrolled</p>
    </div>

    <!-- Search -->
    <form method="GET" action="index.php" class="search-form">
        <input type="hidden" name="action" value="index">
        <input
            type="text"
            name="search"
            value="<?= htmlspecialchars($keyword ?? '') ?>"
            placeholder="Search name ya course..."
            class="search-input">
        <button type="submit" class="btn btn--primary">Search</button>
        <?php if (!empty($keyword)): ?>
            <a href="index.php?action=index" class="btn btn--ghost">Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if (empty($students)): ?>
    <div class="empty-state">
        <span class="empty-icon">📭</span>
        <p>Koi student nahi mila. <a href="index.php?action=create">First Add Student!</a></p>
    </div>
<?php else: ?>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $i => $student): ?>
                    <tr>
                        <td class="td-num"><?= $i + 1 ?></td>
                        <td class="td-name">
                            <div class="avatar"><?= strtoupper(substr($student['name'], 0, 1)) ?></div>
                            <?= htmlspecialchars($student['name']) ?>
                        </td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($student['course']) ?></span></td>
                        <td><?= $student['age'] ?></td>
                        <td class="td-actions">
                            <a href="index.php?action=edit&id=<?= $student['id'] ?>" class="btn btn--sm btn--edit">Edit</a>
                            <a
                                href="index.php?action=delete&id=<?= $student['id'] ?>"
                                class="btn btn--sm btn--danger"
                                onclick="return confirm('Pakka delete karna hai? 🗑️')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>