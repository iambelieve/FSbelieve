<?php
    include 'config/title.php';
    $navtitle = mysqli_fetch_array(mysqli_query($titleconn, "SELECT * FROM ib_fansub_anime LEFT JOIN ib_fansub_project ON ib_fansub_anime.pid=ib_fansub_project.pid WHERE vid = '".$_GET['vid']."'"));
    $ibtitle = 'Watch Online - '.$navtitle['title']." ".$navtitle['episode'];
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
    $anime = $navtitle;
    mysqli_query($conn, "UPDATE ib_fansub_anime SET view = view+1 WHERE vid = '".$_GET['vid']."'");
    $lkw = mysqli_query($conn, "SELECT * FROM ib_fansub_download WHERE link_w_active = 1 AND link_active = 1");
    $lkw2 = mysqli_query($conn, "SELECT * FROM ib_fansub_download WHERE link_w_active = 1 AND link_active = 1");
    $lk = mysqli_query($conn, "SELECT * FROM ib_fansub_download WHERE link_d_active = 1 AND link_active = 1");
    $linkjs = json_decode($anime['linkcontent'],TRUE);
?>
<link href="include/skins/thin-blue.min.css" rel="stylesheet" type="text/css"/>
<script src="include/jwplayer/jwplayer.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="F/za2PskSOKl5VUeZ7filgqkTpnLZ3OSFcIdDg=="</script>
<link href="http://vjs.zencdn.net/5.11.6/video-js.css" rel="stylesheet">
<!-- If you'd like to support IE8 -->
<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4><?php echo $anime['title']." ".$anime['episode'];?><div class="pull-right"><h6>เข้าชม <?php echo ($anime['view']+1);?></h6></div></h4>
            </div>
            <?php if($anime['report']==1) { ?>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#drive" data-toggle="tab"><i class="fa fa-google" aria-hidden="true"></i> GDrive</a></li>
                <?php while ($linkw = mysqli_fetch_array($lkw)) { ?>
                <li><a href="#<?php echo $linkw['link_title']; ?>" data-toggle="tab"><i class="fa fa-youtube-play" aria-hidden="true"></i> <?php echo $linkw['link_title']; ?></a></li>
                <?php } ?>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="drive">
                        <div id="ibplayer">
                            <img src="<?=$data_setting_fatch['video_wait'];?>" width="100%"/>
                        </div>
                        <script type='text/javascript'>
                                    jq.get("https://api.iam-believe.xyz/ib/<?=$anime['gdrive_encode'];?>",function(data){
                                            var link = data['link'];
                                            var ibplayer = jwplayer('ibplayer');
                                            ibplayer.setup({
                                                sources: link,
                                                width: '100%',
                                                aspectratio: '16:9',
                                                skin: {
                                                    name: "thin"
                                                },
                                                image: '<?=$data_setting_fatch['video_cover'];?>',
                                                aboutlink: 'https://iam-believe.xyz',
                                                abouttext: 'FSbelieve Player',
                                                primary: 'html5',
                                                autostart: false
                                            });
                                    },"json");
                        </script>
                </div>
                <?php while ($linkw2 = mysqli_fetch_array($lkw2)) { ?>
                <div class="tab-pane fade" id="<?php echo $linkw2['link_title']; ?>">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video id="my-video" class="video-js embed-responsive-item" controls preload="auto" width="640" height="264"
                                 poster="<?=$data_setting_fatch['video_cover'];?>" data-setup="{}">
                                    <source src="<?php echo $linkjs[$linkw2['link_title']];?>" type='video/mp4'>
                                         <p class="vjs-no-js">
                                             To view this video please enable JavaScript, and consider upgrading to a web browser that
                                             <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                         </p>
                        </video>
                        <script src="http://vjs.zencdn.net/5.11.6/video.js"></script>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
                        <div id="ibplayer">
                            <img src="<?=$data_setting_fatch['video_false'];?>" width="100%"/>
                        </div>
            <?php } ?>
            <table class="table table-striped table-hover ">
                <thead>
                  <tr>
                    <th>Prev</th>
                    <th>Report</th>
                    <th>Download</th>
                    <th>Next</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><a onclick="ibpVideo('<?=$anime['vid'];?>','<?=$anime['pid'];?>');" id="p<?=$anime['vid'];?>" class="btn btn-default">Prev</a></td>
                    <td>
                    <?php if($anime['report']==1) { ?>
                        <a onclick="ibReport('<?=$anime['vid'];?>');" id="<?=$anime['vid'];?>" class="btn btn-default">Report</a>
                    <?php }else{ ?>
                        <a class="btn btn-default disabled">กำลังแก้ไข..</a>
                    <?php } ?>
                    </td>
                    <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Download</button></td>
                    <td><a onclick="ibnVideo('<?=$anime['vid'];?>','<?=$anime['pid'];?>');" id="n<?=$anime['vid'];?>" class="btn btn-default">Next</a></td>
                  </tr>
                </tbody>
              </table> 
            </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Download <?=$anime['title']." ".$anime['episode'];?></h4>
              </div>
              <div class="modal-body">
                <?php 
                echo (($anime['gdrive'])?'<a href="https://docs.google.com/a/kimochii-jp.net/uc?id='.$anime['gdrive'].'&export=download" class="btn btn-primary ib-btn" target="_blank">Google Drive</a>':'');
                while ($link = mysqli_fetch_array($lk)) {
                    echo (($linkjs[$link['link_title']])?'<a class="btn btn-info ib-btn" href="'.$linkjs[$link['link_title']].'" target="_blank">'.$link['link_title'].'</a>':''); 
                }
                 ?>
                <hr>
                <div id="link">
                    <a onclick="getlink('<?=$anime['gdrive'];?>');" id="linkbtn" class="btn btn-danger">Quality Select</a>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
            <div class="col-sm-4 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>Anime Recent</h4>
            </div>
            <div class="list-group">
              <?php $anime_recent = mysqli_query($conn, "SELECT * FROM ib_fansub_anime LEFT JOIN ib_fansub_project ON ib_fansub_anime.pid=ib_fansub_project.pid WHERE ib_fansub_anime.pid = '".$anime['pid']."' ORDER BY rand() LIMIT 7");
               while ($are = mysqli_fetch_array($anime_recent)){
              ?>
              <div href="#" class="list-group-item">
                  <a class="ib-link" href="watch.php?vid=<?=$are['vid'];?>"><?=$are['title']." ".$are['episode'];?></a>
              </div>
               <?php } ?>
            </div>
                <?php include 'template/'.$data_setting_fatch['sitetheme'].'/side.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getlink(gid){
        jq( '#linkbtn' ).html('Processing..');
        jq.get("http://api.iam-believe.xyz/drive/"+gid,function(data){
            if(data['link360']){
                var link360 = '<a href="'+ data['link360'] +'&title=<?=$anime['title']." - ".$anime['episode'];?>" class="btn btn-danger ib-btn" download>360p</a>';
            }else{var link360 = '';}
            if(data['link480']){
                var link480 = '<a href="'+ data['link480'] +'&title=<?=$anime['title']." - ".$anime['episode'];?>" class="btn btn-danger ib-btn" download>480p</a>';
            }else{var link480 = '';}
            if(data['link720']){
                var link720 = '<a href="'+ data['link720'] +'&title=<?=$anime['title']." - ".$anime['episode'];?>" class="btn btn-danger ib-btn" download>720p</a>';
            }else{var link720 = '';}
            if(data['link1080']){
                var link1080 = '<a href="'+ data['link1080'] +'&title=<?=$anime['title']." - ".$anime['episode'];?>" class="btn btn-danger" download>1080p</a>';
            }else{var link1080 = '';}
            var link = link360+link480+link720+link1080;
            jq( '#link' ).html(link);
	},"json");
    };
    function ibReport(vid){
        jq('#'+vid).attr("class","btn btn-default disabled");
        jq('#'+vid).text('กำลังดำเนินการ...');
        jq.post(unescape('report.php%3Fvid%3D')+vid,function(data) {
            if(data=='ok'){
                jq('#'+vid).text('เรียบร้อย!');
            }else{
                jq('#'+vid).attr("class","btn btn-default");
                jq('#'+vid).text('ผิดพลาด!');
            }
        });
    }
    function ibpVideo(vid,pid){
        jq('#p'+vid).attr("class","btn btn-default disabled");
        jq('#p'+vid).text('กำลังไป...');
            jq.post(unescape('video-fanction.php%3Fmod%3Dprev%26vid%3D')+vid+unescape('%26pid%3D')+pid,function(data) {
                if(data == 'null'){
                    jq('#p'+vid).text('ถึงตอนแรกแล้ว!');
                }else{
                    location.href = data;
                }
            });
    }
    function ibnVideo(vid,pid){
        jq('#n'+vid).attr("class","btn btn-default disabled");
        jq('#n'+vid).text('กำลังไป...');
            jq.post(unescape('video-fanction.php%3Fmod%3Dnext%26vid%3D')+vid+unescape('%26pid%3D')+pid,function(data) {
                if(data == 'null'){
                    jq('#n'+vid).text('ตอนสุดท้ายแล้ว');
                }else{
                    location.href = data;
                }
            });
    }
</script>
<?php
    include 'template/'.$data_setting_fatch['sitetheme'].'/footer.php';
?>

