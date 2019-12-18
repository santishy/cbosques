<table class="table table-striped text-center">
  <thead>
    <tr>
      <th>ID</th>
      <th>Concepto</th>
      <th>Monto Inicial</th>
      <th>Monto Actual</th>
      <th>Total Sub.</th>
      <th>Monto Cotizaciones</th>
      <th>Nom. Cotizaciones A.</th>
    </tr>
  </thead>
  <tbody>
    @foreach($budgets as $budget)
      <tr class="table-primary font-weight-bolder">
        <td>{{$budget->id}}</td>
        <td>{{$budget->specification->concept}}</td>
        <td>${{number_format($budget->specification->qty+$budget->total+$items_total[$budget->id],2)}}</td>
        <td>${{number_format($budget->specification->qty,2)}}</td>
        <td>${{number_format($items_total[$budget->id],2)}}</td>
        <td>${{number_format($budget->total,2)}}</th>
        <td>#{{$budget->quotations_count}}</td>
      </tr>
      @foreach($budget->items as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->specification->concept}}</td>
          <td>${{number_format($item->specification->qty+$item->total,2)}}</td>
          <td>${{number_format($item->specification->qty,2)}}</td>
          <td>${{number_format($item->specification->qty,2)}}</td>
          <td>${{number_format($item->total,2)}}</th>
          <td>#{{$item->quotations_count}}</td>
        </tr>
      @endforeach
    @endforeach
  </tbody>
</table>
