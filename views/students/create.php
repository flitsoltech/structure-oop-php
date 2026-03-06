<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title">New Student</h1>
        <p class="page-sub">Add New Student</p>
    </div>
    <a href="index.php?action=index" class="btn btn--ghost">← Wapas Jao</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert--danger">
        <strong>⚠️ Errors:</strong>
        <ul><?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="index.php?action=store" class="form">

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Student Name *</label>
                <input
                    type="text"
                    name="name"
                    class="form-input"
                    value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                    placeholder="e.g. Ali Hassan"
                    required>
            </div>
            <div class="form-group">
                <label class="form-label">Age *</label>
                <input
                    type="number"
                    name="age"
                    class="form-input"
                    value="<?= htmlspecialchars($data['age'] ?? '') ?>"
                    placeholder="18"
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
                value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                placeholder="ali@example.com"
                required>
        </div>

        <div class="form-group">
            <label class="form-label">Course *</label>
            <select name="course" class="form-input" required>
                <option value="">-- Course Select --</option>
                <?php
                $courses  = ['Computer Science', 'Software Engineering', 'Data Science', 'Web Development', 'Cybersecurity', 'AI & ML'];
                $selected = $data['course'] ?? '';
                foreach ($courses as $c):
                ?>
                    <option value="<?= $c ?>" <?= $selected === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn--primary btn--lg">🎓 Student Add Karo</button>
            <a href="index.php?action=index" class="btn btn--ghost btn--lg">Cancel</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>