<?php if($totalPages > 1): ?>
<nav>
  <ul class="pagination justify-content-center">
    <?php if($page > 1): ?>
      <li class="page-item"><a class="page-link" href="?report=<?= $report ?>&startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&page=<?= $page-1 ?>">Previous</a></li>
    <?php endif; ?>
    
    <?php for($i=1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= ($i==$page)?'active':'' ?>">
        <a class="page-link" href="?report=<?= $report ?>&startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if($page < $totalPages): ?>
      <li class="page-item"><a class="page-link" href="?report=<?= $report ?>&startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&page=<?= $page+1 ?>">Next</a></li>
    <?php endif; ?>
  </ul>
</nav>
<?php endif; ?>
