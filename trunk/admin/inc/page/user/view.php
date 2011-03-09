<?php

$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/local.config.php');

$in = $_POST;

$limit       = isset($in['limit'])  && $in['limit'] > 0 && $in['limit'] < 100 ? $in['limit']                : 15;
$startIndex  = isset($in['start'])  && $in['start'] >= 0                      ? $in['start']                : 0;
$filter      = isset($in['filter']) && $in['filter'] != null                  ? stripslashes($in['filter']) : '';

if (!$fullPage) {
  $template = new ModeliXe('user/view.mxt');
  $template->SetModeliXe();
}

$template->MxAttribut($pre."filterValue", $filter);

$template->MxSelect($pre."limitSelect", "limit", $limit, array(
  "5" => "5",
  "10" => "10",
  "15" => "15",
  "20" => "20",
  "25" => "25",
  "30" => "30"
));

 $userManager = new UserManager();
 $count = $userManager->count($filter);
 $nbPage = $count / $limit + 1;
while ($startIndex >= $count)
  $startIndex -= $limit;
if ($startIndex < 0)
  $startIndex = 0;

$currentPage = $startIndex / $limit + 1;
for ($i = 1, $j = 0; $i < $nbPage && $j < 5; $i++) {
  if ($i >= $currentPage - 2) {
    $template->MxAttribut ($pre."pageNav.pageNumberLink", "#");
    if ($i == $currentPage)
        $template->MxAttribut ($pre."pageNav.pageNumberClass", "current other-page");
    else
        $template->MxAttribut ($pre."pageNav.pageNumberClass", "other-page");
    $template->MxText     ($pre."pageNav.pageNumberText", $i);
    $template->MxBloc     ($pre."pageNav", "loop");
    $j++;
  }
}
$template->MxAttribut($pre."maxPage", (int)$nbPage);

$userList = $userManager->getAllUsers($filter, $startIndex, $limit);
if (count($userList) == 0) {
  $template->MxBloc($pre."row", "reset");
} else {
  foreach ($userList as $c) {
      $template->MxCheckerField($pre."row.input.check", "checkbox", "check", $c->getId());
      $template->MxBloc     ($pre."row.input", "loop");
      $template->MxAttribut ($pre."row.mailto", "mailto:".$c->getEmail());
      $template->MxText     ($pre."row.userEmail", $c->getEmail());
      $template->MxText     ($pre."row.userChoices", "");
      $template->MxBloc($pre."row", "loop");
  }
}

if (!$fullPage) {
  $template->MxWrite();
}
?>
