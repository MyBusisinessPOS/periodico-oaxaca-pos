<?php


/**
 * @param $bytes
 * @param int $precision
 * @return string
 */
function formatedSize($bytes, $precision = 1)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * @param $modelObject
 * @param string $attributeName
 * @return null|string|string[]
 */
function getDateColumn($modelObject, $attributeName = 'updated_at', $format = 'd/m/Y h:i:s a')
{
    if (false) {
        $html = '<p data-toggle="tooltip" data-placement="bottom" title="${date}">${dateHuman}</p>';
    } else {
        $html = '<p data-toggle="tooltip" data-placement="bottom" title="${dateHuman}">${date}</p>';
    }
    if (!isset($modelObject[$attributeName])) {
        return '';
    }
    $dateObj = new Carbon\Carbon($modelObject[$attributeName]);
    $replace = preg_replace('/\$\{date\}/', $dateObj->format($format), $html);
    $replace = preg_replace('/\$\{dateHuman\}/', $dateObj->diffForHumans(), $replace);
    return $replace;
}

/**
 * generate boolean column for datatable
 * @param $column
 * @return string
 */
function getBooleanColumn($column, $attributeName)
{
    if (isset($column)) {
        if ($column[$attributeName]) {
            return "<span class='badge badge-success'>SI</span>";
        } else {
            return "<span class='badge badge-danger'>NO</span>";
        }
    }
}

/**
 * @param string $message
 * @param mixed  $data
 *
 * @return array
 */
function makeResponse($message, $data)
{
    return [
        'success' => true,
        'data'    => $data,
        'message' => $message,
    ];
}

/**
 * @param string $message
 * @param array  $data
 *
 * @return array
 */
function makeError($message, array $data = [])
{
    $res = [
        'success' => false,
        'message' => $message,
    ];

    if (!empty($data)) {
        $res['data'] = $data;
    }

    return $res;
}
