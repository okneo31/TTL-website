<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼에서 전송된 데이터를 안전하게 가져옵니다.
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // 모든 필드가 채워졌는지 확인합니다.
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 필수 필드가 비어있거나 이메일 형식이 올바르지 않으면 에러 상태로 리디렉션합니다.
        header("Location: index.html?status=error#contact");
        exit;
    }

    // 이메일을 받을 주소를 설정합니다. *** 반드시 본인의 이메일 주소로 변경해주세요. ***
    $recipient = "jjjajh@naver.com";

    // 이메일 제목을 설정합니다.
    $subject = "새로운 문의가 도착했습니다: " . $name;

    // 이메일 본문을 구성합니다.
    $email_content = "이름: $name\n";
    $email_content .= "이메일: $email\n\n";
    $email_content .= "메시지:\n$message\n";

    // 이메일 헤더를 설정합니다.
    $email_headers = "From: $name <$email>";

    // PHP의 mail() 함수를 사용하여 이메일을 발송합니다.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // 성공적으로 발송되면 성공 상태로 리디렉션합니다.
        header("Location: index.html?status=success#contact");
    } else {
        // 발송에 실패하면 에러 상태로 리디렉션합니다.
        header("Location: index.html?status=error#contact");
    }

} else {
    // POST 요청이 아닐 경우, 에러 메시지를 출력합니다.
    echo "잘못된 접근입니다.";
}
?>
