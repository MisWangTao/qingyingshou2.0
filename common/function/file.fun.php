<?php

function unique_name($dir)
{
    $filename = '';
    while (empty($filename))
    {
        $filename =random_filename();
        if (file_exists($dir . $filename . '.jpg') ||file_exists($dir . $filename . '.jpeg') || file_exists($dir . $filename . '.gif') || file_exists($dir . $filename . '.png'))
        {
            $filename = '';
        }
    }

    return $filename;
}
function random_filename()
{
    $str = '';
    for($i = 0; $i < 9; $i++)
    {
        $str .= mt_rand(0, 9);
    }

    return time() . $str;
}
function make_dir($folder)
{
    $reval = false;

    if (!file_exists($folder))
    {
        /* 如果目录不存在则尝试创建该目录 */
        @umask(0);

        /* 将目录路径拆分成数组 */
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

        /* 如果第一个字符为/则当作物理路径处理 */
        $base = ($atmp[0][0] == '/') ? '/' : '';

        /* 遍历包含路径信息的数组 */
        foreach ($atmp[1] AS $val)
        {
            if ('' != $val)
            {
                $base .= $val;

                if ('..' == $val || '.' == $val)
                {
                    /* 如果目录为.或者..则直接补/继续下一个循环 */
                    $base .= '/';

                    continue;
                }
            }
            else
            {
                continue;
            }

            $base .= '/';

            if (!file_exists($base))
            {
                /* 尝试创建目录，如果创建失败则继续循环 */
                if (@mkdir(rtrim($base, '/'), 0777))
                {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    }
    else
    {
        /* 路径已经存在。返回该路径是不是一个目录 */
        $reval = is_dir($folder);
    }

    clearstatcache();

    return $reval;
}
function img_resource($img_file, $mime_type)
{

    switch ($mime_type)
    {
        case 1:
        case 'image/gif':
            $res = imagecreatefromgif($img_file);
            break;

        case 2:
        case 'image/pjpeg':
        case 'image/jpeg':
            $res = imagecreatefromjpeg($img_file);
            break;

        case 3:
        case 'image/x-png':
        case 'image/png':
            $res = imagecreatefrompng($img_file);
            break;

        default:
            return false;
    }

    return $res;
}
function make_thumb($img, $thumb_width = 0, $thumb_height = 0)
{
    /* 检查缩略图宽度和高度是否合法 */
    if ($thumb_width == 0 && $thumb_height == 0)
    {
        return false;
    }

    /* 检查原始文件是否存在及获得原始文件的信息 */
    $org_info = getimagesize($img);

    $img_org = img_resource($img, $org_info[2]);

    /* 原始图片以及缩略图的尺寸比例 */
    $scale_org      = $org_info[0] / $org_info[1];

    /* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
    if ($thumb_width == 0)
    {
        $thumb_width = $thumb_height * $scale_org;
    }
    if ($thumb_height == 0)
    {
        $thumb_height = $thumb_width / $scale_org;
    }


    $img_thumb  = imagecreatetruecolor($thumb_width, $thumb_height);

    /* 背景颜色 */
    if (empty($bgcolor))
    {
        $bgcolor = "#FFFFFF";
    }
    $bgcolor = trim($bgcolor,"#");
    sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
    $clr = imagecolorallocate($img_thumb, $red, $green, $blue);
    imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);

    if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height)
    {
        $lessen_width  = $thumb_width;
        $lessen_height  = $thumb_width / $scale_org;
    }
    else
    {
        /* 原始图片比较高，则以高度为准 */
        $lessen_width  = $thumb_height * $scale_org;
        $lessen_height = $thumb_height;
    }

    $dst_x = ($thumb_width  - $lessen_width)  / 2;
    $dst_y = ($thumb_height - $lessen_height) / 2;

    /* 将原始图片进行缩放处理 */

    imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);

    /* 创建当月目录 */

    $root     = dirname(dirname(__FILE__));
    $path     = "/upload/".date("Y")."/".date("m")."/";
    $dir      = $root.$path;

    /* 如果目标目录不存在，则创建它 */
    if (!file_exists($dir))
    {
        if (!make_dir($dir))
        {
            /* 创建目录失败 */
            return false;
        }
    }

    /* 如果文件名为空，生成不重名随机文件名 */
    $filename = unique_name($dir);

    /* 生成文件 */
    if (function_exists('imagejpeg'))
    {
        $filename .= '.jpg';
        imagejpeg($img_thumb, $dir . $filename,95);
    }
    elseif (function_exists('imagegif'))
    {
        $filename .= '.gif';
        imagegif($img_thumb, $dir . $filename);
    }
    elseif (function_exists('imagepng'))
    {
        $filename .= '.png';
        imagepng($img_thumb, $dir . $filename);
    }
    else
    {
        return false;
    }

    imagedestroy($img_thumb);
    imagedestroy($img_org);

    //确认文件是否生成
    if (file_exists($dir . $filename))
    {
        return $filename;
    }
    else
    {
        return false;
    }
}