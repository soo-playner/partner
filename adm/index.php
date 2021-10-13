<?php
$sub_menu = '100000';
include_once('./_common.php');

@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

Header("Location:./license_list.php");


$g5['title'] = '관리자메인';
include_once ('./admin.head.php');

$new_member_rows = 5;
$new_point_rows = 5;
$new_write_rows = 5;

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";

if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

$colspan = 12;
?>

<!-- <section>
    <h2>신규가입회원 <?php echo $new_member_rows ?>건 목록</h2>
    <div class="local_desc02 local_desc">
        총회원수 <?php echo number_format($total_count) ?>명 중 차단 <?php echo number_format($intercept_count) ?>명, 탈퇴 : <?php echo number_format($leave_count) ?>명
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>신규가입회원</caption>
        <thead>
        <tr>
            <th scope="col">회원아이디</th>
            <th scope="col">이름</th>
            <th scope="col">닉네임</th>
            <th scope="col">권한</th>
            <th scope="col">포인트</th>
            <th scope="col">수신</th>
            <th scope="col">공개</th>
            <th scope="col">인증</th>
            <th scope="col">차단</th>
            <th scope="col">그룹</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            // 접근가능한 그룹수
            $sql2 = " select count(*) as cnt from {$g5['group_member_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
            $group = "";
            if ($row2['cnt'])
                $group = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">'.$row2['cnt'].'</a>';

            if ($is_admin == 'group')
            {
                $s_mod = '';
                $s_del = '';
            }
            else
            {
                $s_mod = '<a href="./member_form.php?$qstr&amp;w=u&amp;mb_id='.$row['mb_id'].'">수정</a>';
                $s_del = '<a href="./member_delete.php?'.$qstr.'&amp;w=d&amp;mb_id='.$row['mb_id'].'&amp;url='.$_SERVER['SCRIPT_NAME'].'" onclick="return delete_confirm(this);">삭제</a>';
            }
            $s_grp = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">그룹</a>';

            $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date("Ymd", G5_SERVER_TIME);
            $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date("Ymd", G5_SERVER_TIME);

            $mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

            $mb_id = $row['mb_id'];
        ?>
        <tr>
            <td class="td_mbid"><?php echo $mb_id ?></td>
            <td class="td_mbname"><?php echo get_text($row['mb_name']); ?></td>
            <td class="td_mbname sv_use"><div><?php echo $mb_nick ?></div></td>
            <td class="td_num"><?php echo $row['mb_level'] ?></td>
            <td><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo number_format($row['mb_point']) ?></a></td>
            <td class="td_boolean"><?php echo $row['mb_mailling']?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo $row['mb_open']?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo preg_match('/[1-9]/', $row['mb_email_certify'])?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo $row['mb_intercept_date']?'예':'아니오'; ?></td>
            <td class="td_category"><?php echo $group ?></td>
        </tr>
        <?php
            }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./member_list.php">회원 전체보기</a>
    </div>

</section>

<?php
$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if (isset($view) && $view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}
$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$colspan = 5;
?>

<section>
    <h2>최근게시물</h2>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근게시물</caption>
        <thead>
        <tr>
            <th scope="col">그룹</th>
            <th scope="col">게시판</th>
            <th scope="col">제목</th>
            <th scope="col">이름</th>
            <th scope="col">일시</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

            if ($row['wr_id'] == $row['wr_parent']) // 원글
            {
                $comment = "";
                $comment_link = "";
                $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row2['wr_datetime'],0,10);
                $datetime2 = $row2['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);

            }
            else // 코멘트
            {
                $comment = '댓글. ';
                $comment_link = '#c_'.$row['wr_id'];
                $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row3['wr_datetime'],0,10);
                $datetime2 = $row3['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);
            }
        ?>

        <tr>
            <td class="td_category"><a href="<?php echo G5_BBS_URL ?>/new.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo cut_str($row['gr_subject'],10) ?></a></td>
            <td class="td_category"><a href="<?php echo get_pretty_url($row['bo_table']) ?>"><?php echo cut_str($row['bo_subject'],20) ?></a></td>
            <td><a href="<?php echo get_pretty_url($row['bo_table'], $row2['wr_id']); ?><?php echo $comment_link ?>"><?php echo $comment ?><?php echo conv_subject($row2['wr_subject'], 100) ?></a></td>
            <td class="td_mbname"><div><?php echo $name ?></div></td>
            <td class="td_datetime"><?php echo $datetime ?></td>
        </tr>

        <?php
        }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="<?php echo G5_BBS_URL ?>/new.php">최근게시물 더보기</a>
    </div>
</section>

<?php
$sql_common = " from {$g5['point_table']} ";
$sql_search = " where (1) ";
$sql_order = " order by po_id desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_point_rows} ";
$result = sql_query($sql);

$colspan = 7;
?>

<section>
    <h2>최근 포인트 발생내역</h2>
    <div class="local_desc02 local_desc">
        전체 <?php echo number_format($total_count) ?> 건 중 <?php echo $new_point_rows ?>건 목록
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근 포인트 발생내역</caption>
        <thead>
        <tr>
            <th scope="col">회원아이디</th>
            <th scope="col">이름</th>
            <th scope="col">닉네임</th>
            <th scope="col">일시</th>
            <th scope="col">포인트 내용</th>
            <th scope="col">포인트</th>
            <th scope="col">포인트합</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $row2['mb_id'] = '';
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            if ($row2['mb_id'] != $row['mb_id'])
            {
                $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                $row2 = sql_fetch($sql2);
            }

            $mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

            $link1 = $link2 = "";
            if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table'])
            {
                $link1 = '<a href="'.get_pretty_url($row['po_rel_table'], $row['po_rel_id']).'" target="_blank">';
                $link2 = '</a>';
            }
        ?>

        <tr>
            <td class="td_mbid"><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
            <td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td>
            <td class="td_name sv_use"><div><?php echo $mb_nick ?></div></td>
            <td class="td_datetime"><?php echo $row['po_datetime'] ?></td>
            <td><?php echo $link1.$row['po_content'].$link2 ?></td>
            <td class="td_numbig"><?php echo number_format($row['po_point']) ?></td>
            <td class="td_numbig"><?php echo number_format($row['po_mb_point']) ?></td>
        </tr>

        <?php
        }

        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./point_list.php">포인트내역 전체보기</a>
    </div>
</section> -->

<link href="<?=G5_ADMIN_URL?>/css/scss/include/new_default.css" rel="stylesheet">
<link href="<?=G5_ADMIN_URL?>/css/scss/page/index.css" rel="stylesheet">


<link href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet">
<link href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/stove99/jquery-modal-sample@v1.4/css/animate.min.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/stove99/jquery-modal-sample@v1.4/css/jquery.modal.css" />
<script src="//cdn.jsdelivr.net/gh/stove99/jquery-modal-sample@v1.4/js/jquery.modal.js"></script>
<script src="//cdn.jsdelivr.net/gh/stove99/jquery-modal-sample@v1.4/js/modal.js"></script>
<div class="adm_main_wrap">
    <section class="top_wrap">
        <div class="user_num_wrap content-box-nomargin">
            <form action="">
                <div>
                    <?php include_once('./adm_user_chart.php'); ?>
                </div>
                <div class="search_wrap">
                    <ul>
                        <li>
                            <select name="" id="" class="form-control">
                                <option value="">2020-12-01 ~ 2021-03-01</option>
                            </select>
                        </li>
                        <li>
                            <a href="" id="user_chart_submit" class="search_btn"></a>
                        </li>
                    </ul>
                </div>
                <script>
                    $(function() {
                        $('.blocker').css('display','none');
                        $('#user_chart_submit').on('click',function(e) {
                            e.preventDefault();
                            // $('body').css('overflow','auto !important');
                            $('.blocker').css('display','none !important');
                            $.popup({
                                url: './user_popup.php',
                                close: function(result) {
                                    console.log(result);
                                }
                            });
                        });
                    });
                </script>
            </form>
            <?php echo $varl;?>
        </div>
        <div>
            <?php
                $sql_common = " from {$g5['member_table']} ";

                $sql_search = " where (1) ";
                if ($stx) {
                    $sql_search .= " and ( ";
                    switch ($sfl) {
                        case 'mb_point' :
                            $sql_search .= " ({$sfl} >= '{$stx}') ";
                            break;
                        case 'mb_level' :
                            $sql_search .= " ({$sfl} = '{$stx}') ";
                            break;
                        case 'mb_tel' :
                        case 'mb_hp' :
                            $sql_search .= " ({$sfl} like '%{$stx}') ";
                            break;
                        default :
                            $sql_search .= " ({$sfl} like '{$stx}%') ";
                            break;
                    }
                    $sql_search .= " ) ";
                }

                if ($is_admin != 'super')
                    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

                if (!$sst) {
                    $sst = "mb_datetime";
                    $sod = "desc";
                }

                $sql_order = " order by {$sst} {$sod} ";

                $sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
                $row = sql_fetch($sql);
                $total_count = $row['cnt'];

                // 탈퇴회원수
                $sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
                $row = sql_fetch($sql);
                $leave_count = $row['cnt'];

                // // 차단회원수
                $sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
                $row = sql_fetch($sql);
                $intercept_count = $row['cnt'];
            ?>
            <div class="total_member_wrap">
                <div class="left_wrap">
                    <p>총 회원수 <br> <?php echo number_format($total_count)?>명</p>
                </div>
                <div class="right_wrap">
                    <span>차단:<?php echo number_format($intercept_count)?>명</span>
                    <span>탈퇴:<?php echo number_format($leave_count)?>명</span>
                </div>
            </div>
            <div class="new_sign_wrap content-box">
                <div class="title_wrap">
                    <p>신규가입회원</p>
                </div>
                <div class="content_wrap slick_sign">
                    <div>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                        <ul>
                            <li class="img_wrap">
                                <img src="<?=G5_ADMIN_URL?>/img/grade.png" width="34" alt="이미지">
                                <span class="title">xkaizew</span>
                            </li>
                            <li class="date">2021/07/12</li>
                        </ul>
                    </div>
                </div>
                <script>
                    $(function() {
                        $('.slick_sign').slick({
                            slide: 'div',
                            dots: false,
                            speed: 500,
                            autoplay:true,
                            slidesToShow: 1,
                            arrows: true,
                            prevArrow: "<button type='button' class='slick-prev' style='top:-12%;left:83%'><img src='<?=G5_ADMIN_URL?>/img/left.png' width='25' alt='이미지'></button>",
                            nextArrow: "<button type='button' class='slick-next' style='top:-12%;right:0%'><img src='<?=G5_ADMIN_URL?>/img/right.png' width='25' alt='이미지'></button>"
                        });
                    })
                </script>
            </div>
        </div>
    </section>
    <section class="mid_top_wrap">
        <div class="card_wrap card_wrap1 content-box-nomargin">
            <div class="title_wrap">
                <img src="<?=G5_ADMIN_URL?>/img/deposit.png" width="34" alt="이미지">
                <span>입금액</span>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>누적입금액 <br>₩860,000,000</p>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>당일입금액 <br>₩860,000,000</p>
            </div>
        </div>
        <div class="card_wrap card_wrap2 content-box content-box-nomargin">
            <div class="title_wrap">
                <img src="<?=G5_ADMIN_URL?>/img/sell.png" width="34" alt="이미지">
                <span>판매금액</span>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>누적판매금액 <br>₩860,000,000</p>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>당일판매금액 <br>₩860,000,000</p>
            </div>
        </div>
        <div class="card_wrap card_wrap3 content-box-nomargin">
            <div class="title_wrap">
                <img src="<?=G5_ADMIN_URL?>/img/withdrawl.png" width="34" alt="이미지">
                <span>출금액</span>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>누적출금액 <br>₩860,000</p>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>당일출금액 <br>₩860,000</p>
            </div>
        </div>
        <div class="card_wrap card_wrap4 content-box-nomargin">
            <div class="title_wrap">
                <img src="<?=G5_ADMIN_URL?>/img/bonus.png" width="34" alt="이미지">
                <span>보너스지급액</span>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>누적보너스지급액 <br>₩860,000</p>
            </div>
            <div class="content_wrap">
                <div class="dot"></div>
                <p>전일보너스지급액 <br>₩860,000</p>
            </div>
        </div>
    </section>
    <section class="mid_bottom_wrap">
        <div class="card_wrap content-box-nomargin">
            <div class="content_wrap money_statistics">
                <?php include_once('./money_statistics_chart.php'); ?>
            </div>
            <div class="title_wrap">
                <div class="all_view"><a href="">View All</a></div>
            </div>
        </div>
        <div class="card_wrap content-box-nomargin">
            <div class="content_wrap statistics">
                <div class="post_statistics">
                    <?php
                        $notice_sql = "select * from g5_write_notice";
                        $notice_sql_query = sql_query($notice_sql);
                        $notice_sql_sum = sql_num_rows($notice_sql_query);

                        $free_sql = "select * from g5_write_qa";
                        $free_sql_query = sql_query($free_sql);
                        $free_sql_sum = sql_num_rows($free_sql_query);

                        $qa_sql = "select * from g5_write_free";
                        $qa_sql_query = sql_query($qa_sql);
                        $qa_sql_sum = sql_num_rows($qa_sql_query);

                    ?>
                    <?php include_once('./post_statistics_chart.php'); ?>
                    <div class="statistics_sum">
                        <div class="statistics_list">
                            <span>공지사항</span>
                            <span class="notice_val"></span>
                        </div>
                        <div class="statistics_list">
                            <span>Q&A</span>
                            <span class="qa_val"></span>
                        </div>
                        <div class="statistics_list">
                            <span>자유게시판</span>
                            <span class="free_val"></span>
                        </div>
                        <div class="statistics_list">
                            <span>문의사항</span>
                            <span class="reply_val"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card_wrap content-box-nomargin">
            <div class="title_wrap">
                <p>이체요청내역</p>
            </div>
            <div class="content_wrap slick_transfer">
                <div>
                    <ul>
                        <li class="state withdrawl">
                            <p><i class="ri-arrow-left-line"></i></p>
                            <p>출금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text state_ok">승인</li>
                    </ul>
                    <ul>
                        <li class="state deposit">
                            <p><i class="ri-arrow-right-line"></i></p>
                            <p>입금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text state_waiting">확인중</li>
                    </ul>
                    <ul>
                        <li class="state deposit">
                            <p><i class="ri-arrow-right-line"></i></p>
                            <p>입금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text">승인</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li class="state withdrawl">
                            <p><i class="ri-arrow-left-line"></i></p>
                            <p>출금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text state_ok">승인</li>
                    </ul>
                    <ul>
                        <li class="state deposit">
                            <p><i class="ri-arrow-right-line"></i></p>
                            <p>입금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text state_waiting">확인중</li>
                    </ul>
                    <ul>
                        <li class="state deposit">
                            <p><i class="ri-arrow-right-line"></i></p>
                            <p>입금</p>
                        </li>
                        <li class="name">
                            <p>SJC8388</p>
                            <p>김은혜</p>
                        </li>
                        <li class="date">2021-07-12 23:16:24</li>
                        <li class="state_text">승인</li>
                    </ul>
                </div>
            </div>
            <script>
                $(function() {
                    $('.slick_transfer').slick({
                        slide: 'div',
                        dots: false,
                        speed: 500,
                        autoplay:true,
                        slidesToShow: 1,
                        arrows: true,
                        prevArrow: "<button type='button' class='slick-prev' style='top:-12%;left:83%'><img src='<?=G5_ADMIN_URL?>/img/left.png' width='25' alt='이미지'></button>",
                        nextArrow: "<button type='button' class='slick-next' style='top:-12%;right:0%'><img src='<?=G5_ADMIN_URL?>/img/right.png' width='25' alt='이미지'></button>"
                    });
                })
            </script>
        </div>
    </section>
    <section class="bottom_wrap">
        <div class="card_wrap content-box-nomargin recent">
            <div class="title_wrap">
                <p>최근게시물</p>
                <div class="nav_wrap">
                    <ul>
                        <a href=""><li>공지사항</li></a>
                        <a href=""><li>자유게시판</li></a>
                    </ul>
                </div>
                <div class="all_view"><a href="">View All</a></div>
            </div>
            <div class="content_wrap">
                <div class="tbl_wrap tbl_head01">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">작성자</th>
                                <th scope="col">제목</th>
                                <th scope="col">일자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td class="td_id">admin</td>
                                <td class="td_left">No Data Available.</td>
                                <td class="td_idsmall td_category1">2021-07-10</td>
                            </tr>
                            <tr class="">
                                <td class="td_id">admin</td>
                                <td class="td_left">No Data Available.</td>
                                <td class="td_idsmall td_category1">2021-07-10</td>
                            </tr>
                            <tr class="">
                                <td class="td_id">admin</td>
                                <td class="td_left">No Data Available.</td>
                                <td class="td_idsmall td_category1">2021-07-10</td>
                            </tr>
                            <tr class="">
                                <td class="td_id">admin</td>
                                <td class="td_left">No Data Available.</td>
                                <td class="td_idsmall td_category1">2021-07-10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card_wrap">
            <div class="title_wrap">
                <p>문의사항</p>
                <div class="all_view"><a href="">View All</a></div>
            </div>
            <div class="content_wrap customer">
                <div class="top_card_wrap">
                    <div class="title">
                        <p>입금내역은 어디서 볼수있을까요?</p>
                        <p>2021-07-15 12:00 - wretr88***</p>
                    </div>
                    <div class="more">
                        <a href=""><img src="<?=G5_ADMIN_URL?>/img/more.png" width="25" alt="이미지"></a>
                    </div>
                </div>
                <div class="bottom_card_wrap">
                    <div class="content">
                        <p>입금내역은 어디서 볼수 있을까요? 내역조회가 안되요.</p>
                    </div>
                    <div class="grade_icon_wrap">
                        <a href=""><img src="<?=G5_ADMIN_URL?>/img/grade.png" width="25" alt="이미지"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include_once ('./admin.tail.php');