<?php
$config = parse_ini_file(__DIR__ . '/config.ini', $process_sections = true);


try {
    $pdo = get_pdo_connect($config['db']['dsn'], $config['db']['user'], $config['db']['password']);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}
$time = time();

echo "wordpress.posts.open\t" . get_open_posts_count() . "\t{$time}\n";
echo "wordpress.posts.closed\t" . get_closed_posts_count() . "\t{$time}\n";
echo "wordpress.user_count\t" . get_user_count() . "\t{$time}\n";
echo "wordpress.user_count\t" . get_user_count() . "\t{$time}\n";

function get_pdo_connect($dsn, $user, $password)
{
    return new PDO($dsn, $user, $password);
}

function get_count_result($sql)
{
    global $pdo;
    $stmt = $pdo->query($sql);
    return $stmt->fetch()[0];
}

function get_user_count()
{
    $sql = 'SELECT count(*) FROM wp_users';
    return get_count_result($sql);
}

function get_open_posts_count()
{
    $sql = "SELECT count(*) FROM wp_posts WHERE ping_status = 'open'";
    return get_count_result($sql);
}

function get_closed_posts_count()
{
    $sql = "SELECT count(*) FROM wp_posts WHERE ping_status = 'closed'";
    return get_count_result($sql);
}

