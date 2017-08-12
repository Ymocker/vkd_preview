<div>
    <a href="http://6.pogoda.by/26666" style="font-family:Tahoma; font-size:10px; color:#990000;"
       title="Погода. Витебск на 6 дней - Гидрометцентр РБ" target="_blank">Погода. ВИТЕБСК</a>
</div>
<table width=250px height=100% align="left" style="font-family:Tahoma; font-size:10px; color:#990000;"
       cellpadding="0" cellspacing="2">
    <tr>
        <td>
            <script defer type="text/javascript">
                <?php
                    $url = 'http://pogoda.by/meteoinformer/js/26666_1.js';
                        if ($content = @file_get_contents($url)) {
                            $content = iconv('windows-1251', 'utf-8', $content);
                        } else {
                            $content = 'Ошибка соединения, cервер временно не доступен';
                        }
                    echo $content;
                ?>
            </script>
        </td>
    </tr>
</table>
<table width=250px height=100% style="font-family:Tahoma; font-size:10px; color:#990000;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            Информация с сайта <a href="http://www.pogoda.by" target="_blank" style="font-family:Tahoma;
                                  font-size:10px; color:#003399;">pogoda.by</a>
        </td>
    </tr>
</table>

<hr width="230px" style="border:thin #CCCCCC dotted" align="left" />

<div align="left" style="margin-left: 0px;">
    <iframe src="http://www.nbrb.by/publications/wmastersd.asp?datatype=
            2&fnt=Tahoma&fntsize=10&fntcolor=aa0000&lnkcolor=aa0000&bgcolor=f0ebc0&brdcolor=f0ebc0"
        width=230 height=100 frameborder=0 scrolling=no>
    </iframe>
</div>

<hr width="230px" style="border:thin #CCCCCC dotted" align="left" />

<style>
    .color_header_bg{padding-left:25px;font-size: 0.8em;}
    .color_header_bg a{text-decoration:none;}
    .color_header_bg a:hover{text-decoration:none;}
    .n_text{padding-bottom:1px;font-size: 0.9em;}
    .n_date{padding-bottom:1px;font-size: 0.8em;}
    .n_title{padding:10px 0px 0px 0px;font-weight:bold;font-size: 1em;}
    .n_title a{text-decoration:none;}
    .n_title a:hover{text-decoration:underline;}
    .tbl_ms{text-align:left;vertical-align:top;font-size: 0.8em;}
    .inf_bord{}
    .arr_st{padding:13px 6px 0px 4px;vertical-align:top;}
</style>
<table width="230" border="0" cellspacing="0" cellpadding="0" class="inf_bord">
    <tr>
        <td class="color_header_bg" align="left">
            <a href="http://www.belta.by" target="_blank">www.belta.by</a>
        </td>
    </tr>
    <tr>
        <td id="n_t" style="padding-right:4px;"></td>
    </tr>
    <script defer src='http://www.belta.by/newimages/news_informer/n_inf_3_1.js'></script>
</table>
