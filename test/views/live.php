<main class="pt-4">
  <div class="row">
    <div class="col-md-12">
      <div class="text-center">
        <h1><?= $c->from() ?></h1>
      </div>
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
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">USD</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>