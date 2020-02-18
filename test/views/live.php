<main class="pt-4">
  <div class="row">
    <div class="col-md-12">
      <div class="text-center">
        <h1>USD</h1>
      </div>
      <?= $c->get_data()->pre() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <ul>
        <li><?= $c->convert(1, 'TWD')->suffix('1 USD to TWD is')->__toString(); ?></li>
        <li><?= $c->convert(1, 'EUR')->suffix('1 USD to EUR is')->__toString() ?></li>
        <li><?= $c->convert(1, 'IDR')->suffix('1 USD to IDR is')->__toString() ?></li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="text-center">
        <h4>Available Currency For USD</h4>
        <?= $c->available()->n2s()->pre() ?>
      </div>
    </div>
  </div>
</main>