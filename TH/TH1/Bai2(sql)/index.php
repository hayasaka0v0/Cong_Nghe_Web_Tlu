<?php
$questions = [];
$results = null;

require 'connection.php';

// Lấy tất cả các câu trả lời đúng từ cơ sở dữ liệu và lưu vào mảng
$correct_answers = [];
$sql = "SELECT stt, dap_an FROM trac_nghiem";
$stmt = $conn->prepare($sql);
$stmt->execute(); // Thực thi truy vấn

// Duyệt qua kết quả và lưu vào mảng
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $correct_answers[$row['stt']] = trim($row['dap_an']); // Xóa khoảng trắng trong đáp án từ SQL
}

// Xử lý tải tệp lên và đọc câu hỏi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['quiz_file'])) {
    $file = $_FILES['quiz_file']['tmp_name'];

    if (file_exists($file)) {
        $content = file($file);
        $question = null;

        foreach ($content as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (strpos($line, 'ANSWER:') === 0) {
                // Tách câu trả lời
                $question['answer'] = substr($line, 7); // Đảm bảo là chuỗi "A, B, C"
                $questions[] = $question;
                $question = null;
            } elseif (strpos($line, 'A.') === 0 || strpos($line, 'B.') === 0 || strpos($line, 'C.') === 0 || strpos($line, 'D.') === 0) {
                // Thêm các đáp án
                $question['options'][] = $line;
            } else {
                // Câu hỏi
                $question['question'] = $line;
            }
        }
    }
}

// Xử lý khi người dùng nộp bài
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $questions = json_decode($_POST['questions'], true);
    $score = 0;
    $results = [];

    foreach ($questions as $index => $q) {
        // Lấy đáp án người dùng đã chọn
        $selected = $_POST["question_$index"] ?? []; 
        $selected_answers = array_map('trim', $selected); // Xóa khoảng trắng trong đáp án người dùng chọn

        // Lấy STT của câu hỏi (giả sử STT là chỉ mục của mảng)
        $question_stt = $index + 1;

        // Lấy đáp án đúng từ mảng `$correct_answers` dựa trên STT
        $correct_answer_from_sql = $correct_answers[$question_stt] ?? null;

        // Xóa khoảng trắng trong đáp án từ SQL (thêm một lần nữa để đảm bảo)
        $correct_answer_from_sql = trim($correct_answer_from_sql);

        // So sánh đáp án đúng với đáp án từ checkbox
        $is_correct = in_array($correct_answer_from_sql, $selected_answers);

        // Lưu kết quả cho từng câu hỏi
        $results[] = [
            'question' => $q['question'],
            'is_correct' => $is_correct,
            'correct_answer' => $correct_answer_from_sql,
            'selected' => implode(',', $selected_answers),
        ];

        // Tính điểm nếu câu trả lời đúng
        if ($is_correct) {
            $score++;
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Bài Thi Trắc Nghiệm</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <main>
        <div class="container mt-4">
            <h1 class="text-center">Bài Thi Trắc Nghiệm</h1>

            <!-- Form tải tệp TXT -->
            <?php if (empty($questions) && $results === null): ?>
                <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
                    <div class="mb-3">
                        <label for="quiz_file" class="form-label">Chọn tệp câu hỏi (.txt):</label>
                        <input type="file" name="quiz_file" id="quiz_file" class="form-control" accept=".txt" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </form>
            <?php endif; ?>

            <!-- Hiển thị các câu hỏi -->
            <?php if (!empty($questions) && $results === null): ?>
                <form action="" method="POST">
                    <input type="hidden" name="questions" value='<?= json_encode($questions) ?>'>
                    <?php foreach ($questions as $index => $q): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Câu <?= $index + 1 ?>: <?= $q['question'] ?></h5>
                                <div class="options">
                                    <?php foreach ($q['options'] as $option): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="question_<?= $index ?>[]" value="<?= $option ?>" id="q<?= $index ?>_<?= $option ?>">
                                            <label class="form-check-label" for="q<?= $index ?>_<?= $option ?>">
                                                <?= $option ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" name="submit_quiz" class="btn btn-success">Nộp bài</button>
                </form>
            <?php endif; ?>

            <!-- Hiển thị kết quả -->
            <?php if ($results !== null): ?>
                <h3>Kết Quả:</h3>
                <p>Bạn đã trả lời đúng <?= $score ?>/<?= count($results) ?> câu.</p>

                <div class="accordion" id="resultAccordion">
                    <?php foreach ($results as $index => $result): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                    Câu <?= $index + 1 ?>: <?= $result['is_correct'] ? 'Đúng' : 'Sai' ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#resultAccordion">
                                <div class="accordion-body">
                                    <p><strong>Câu hỏi:</strong> <?= $result['question'] ?></p>
                                    <p><strong>Đáp án đúng:</strong> <?= $result['correct_answer'] ?></p>
                                    <p><strong>Đáp án của bạn:</strong> <?= $result['selected'] ?? 'Không chọn' ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="" class="btn btn-primary mt-3">Làm lại</a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
