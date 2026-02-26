 @extends('layouts.app')

@section('title', 'Public Profile Preview')

@section('content')


 <section class="dashboard-section">
      <div class="container">
        <div class="dashboard-layout">
            @include('candidates.partials.sidebar')
          <div class="dashboard-main">
            <div class="dashboard-page-header">
              <div>
                <h1>Payment History</h1>
                <p>
                  All package renewals, one-off purchases, and receipts in a
                  single place.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-download" aria-hidden="true"></i>
                  Export CSV</a
                >
                <a href="#." class="btn btn-primary"
                  ><i class="fa-solid fa-credit-card" aria-hidden="true"></i>
                  Update card</a
                >
              </div>
            </div>

            <div class="list-card">
              <h3>Recent Transactions</h3>
              <div class="table-responsive">
                <table class="table-modern">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Invoice</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Mar 31, 2025</td>
                      <td>Pro Candidate Plan · Renewal</td>
                      <td>$29.00</td>
                      <td><span class="pill">Paid</span></td>
                      <td>
                        <a
                          href="#."
                          class="btn btn-outline-primary btn-sm rounded-3"
                          >INV-2048</a
                        >
                      </td>
                    </tr>
                    <tr>
                      <td>Feb 18, 2025</td>
                      <td>Concierge Session Add-on</td>
                      <td>$79.00</td>
                      <td><span class="pill">Paid</span></td>
                      <td>
                        <a
                          href="#."
                          class="btn btn-outline-primary btn-sm rounded-3"
                          >INV-2012</a
                        >
                      </td>
                    </tr>
                    <tr>
                      <td>Jan 31, 2025</td>
                      <td>Pro Candidate Plan · Renewal</td>
                      <td>$29.00</td>
                      <td><span class="pill">Paid</span></td>
                      <td>
                        <a
                          href="#."
                          class="btn btn-outline-primary btn-sm rounded-3"
                          >INV-1984</a
                        >
                      </td>
                    </tr>
                    <tr>
                      <td>Dec 15, 2024</td>
                      <td>Elite trial upgrade</td>
                      <td>$0.00</td>
                      <td><span class="pill">Promo</span></td>
                      <td>
                        <a
                          href="#."
                          class="btn btn-outline-secondary btn-sm rounded-3"
                          >INV-1901</a
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



@endsection