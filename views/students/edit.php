<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Student Edit</h1>
        <p class="page-sub">ID #<?= $student['id'] ?> · <?= htmlspecialchars($student['name']) ?></p>
    </div>
    <a href="index.php?action=index" class="btn btn--ghost">← Back</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert--danger">
        <strong>⚠️ Errors:</strong>
        <ul><?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="index.php?action=update" class="form">
        <input type="hidden" name="id" value="<?= $student['id'] ?>">

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Student Namre *</label>
                <input
                    type="text"
                    name="name"
                    class="form-input"
                    value="<?= htmlspecialchars($student['name']) ?>"
                    required>
            </div>
            <div class="form-group">
                <label class="form-label">Age *</label>
                <input
                    type="number"
                    name="age"
                    class="form-input"
                    value="<?= htmlspecialchars($student['age']) ?>"
                    min="5" max="100"
                    required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email *</label>
            <input
                type="email"
                name="email"
                class="form-input"
                value="<?= htmlspecialchars($student['email']) ?>"
                required>
        </div>

        <div class="form-group">
            <label class="form-label">Course *</label>
            <select name="course" class="form-input" required>
                <?php
                $courses = ['Computer Science', 'Software Engineering', 'Data Science', 'Web Development', 'Cybersecurity', 'AI & ML'];
                foreach ($courses as $c):
                ?>
                    <option value="<?= $c ?>" <?= $student['course'] === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn--primary btn--lg">💾 Update Karo</button>
            <a href="index.php?action=index" class="btn btn--ghost btn--lg">Cancel</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>