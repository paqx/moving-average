<?php

$meta = [
	'title' => 'Скользящее среднее для температуры в Москве за 2021 год',
];

?>

<div class="container bg-white border">
	<div class="row mt-3">
		<form action="/" method="GET">
			<div class="col-md-5">
				<ul class="pagination">
					<li class="page-item <?php if (!isset($prevPage)) { echo 'disabled'; } ?>">
						<a class="page-link" href="<?php echo '/?page='.$prevPage ?>">&laquo; Предыдущая страница</a>
					</li>
					<li class="page-item <?php if (!isset($nextPage)) { echo 'disabled'; } ?>">
						<a class="page-link" href="<?php echo '/?page='.$nextPage ?>">Следующая страница &raquo;</a>
					</li>
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="col">
			<table class="table">
				<thead>
					<tr>
						<th>Дата</th>
						<th>Исходное значение</th>
						<th>Вычисленное значение</th>
					</tr>
				</thead>
				<tbody>
					<?php
						
						foreach ($rows as $row) {
							echo '<tr>';
							echo '<td>'.$row['date'].'</td>';
							echo '<td>';
							foreach ($row['origValues'] as $origValue) {
								echo $origValue.', ';
							}
							echo '</td>';
							echo '<td>'.$row['maValue'].'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>