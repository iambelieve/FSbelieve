<?php
    $ibtitle = 'หน้าแรก';
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
    $search = mysqli_query($conn, "SELECT * FROM ib_fansub_project WHERE title LIKE '%".$_POST['textsrc']."%' ORDER BY dateline ASC ");
    //TOPIC
    $topic = mysqli_query($conn, "SELECT * FROM ib_fansub_topic ORDER BY date DESC LIMIT 5");
?>
    <div class="container">
        <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>Project Results : <?php echo $_POST['textsrc']; ?></h4>
            </div>
            <div class="list-group">
                <?php while($searchs = mysqli_fetch_array($search)){ ?>
                    <div class="list-group-item">
                        <div class="row">
                        <a href="project.php?pid=<?=$searchs['pid'];?>"><div class="col-sm-3 col-xs-12" style="margin-left: 10px; background: url(<?php echo $searchs['thumbnail']; ?>) center center / cover; width: 80px; height: 80px;">
                            </div></a>
                        <div class="col-sm-9 col-xs-12">
                            <h5 class="list-group-item-heading"><a class="ib-link" href="project.php?pid=<?=$searchs['pid'];?>"><?php echo $searchs['title']; ?></a> <span style="font-size:12px; color:#c0c0c0"><?php echo ago($searchs['dateline']);?></span></h5>
                            <p class="list-group-item-text" style="line-height: 18px;"><?php echo (($searchs['onair']=='1')?'OnGoing':'Complete');?><br/><?php echo (($searchs['co_work'])?"<b>Co-work :</b> ".$searchs['co_work']."<br/>":'');?></p>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            </div>
            <div class="col-sm-4 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>Announcements</h4>
            </div>
            <div class="list-group">
            <?php while ($tp = mysqli_fetch_array($topic)){ ?>
              <div class="list-group-item">
                  <a class="ib-link" href="topic.php?mod=read&tid=<?=$tp['tid'];?>"><?=$tp['topic'];?></a>
              </div>
            <?php } ?>
            </div>
            <?php include 'template/'.$data_setting_fatch['sitetheme'].'/side.php'; ?>
        </div>
        </div>
    </div>
<?php
    include 'template/'.$data_setting_fatch['sitetheme'].'/footer.php';
?>