<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Payment history</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_payment_history_border:#E4E7EE;
      --my_profile_settings_tab_payment_history_text:#111827;
      --my_profile_settings_tab_payment_history_muted:#6B7280;
      --my_profile_settings_tab_payment_history_btn_border:#000;
      --my_profile_settings_tab_payment_history_btn_text:#000;
      --my_profile_settings_tab_payment_history_btn_hover:#F6F7FB;
      --my_profile_settings_tab_payment_history_radius:12px;
      --my_profile_settings_tab_payment_history_red:#FF3B11;
    }

    body{ font-family: 'Inter', sans-serif; color: var(--my_profile_settings_tab_payment_history_text); }

    .my_profile_settings_tab_payment_history_table{
      width:100%;
      border-collapse:collapse;
      font-size:15px;
    }
    .my_profile_settings_tab_payment_history_table th,
    .my_profile_settings_tab_payment_history_table td{
      padding:12px 10px;
      border-bottom:1px solid var(--my_profile_settings_tab_payment_history_border);
      text-align:left;
    }
    .my_profile_settings_tab_payment_history_table th{
      color:var(--my_profile_settings_tab_payment_history_muted);
      font-weight:500;
      text-transform:uppercase;
      font-size:13px;
    }

    .my_profile_settings_tab_payment_history_table td{
      color:var(--my_profile_settings_tab_payment_history_text);
      /* font-weight:500; */
    }

    .my_profile_settings_tab_payment_history_link{
      color:#000;
      font-weight:600;
      text-decoration:none;
    }
    .my_profile_settings_tab_payment_history_link:hover{ text-decoration:underline; }

    .my_profile_settings_tab_payment_history_update_btn{
      border:1px solid var(--my_profile_settings_tab_payment_history_btn_border);
      color:var(--my_profile_settings_tab_payment_history_btn_text);
      border-radius:10px;
      font-weight:600;
      padding:.6rem 1.2rem;
      background:#fff;
      transition:background .15s ease;
    }
    .my_profile_settings_tab_payment_history_update_btn:hover{
      background:var(--my_profile_settings_tab_payment_history_btn_hover);
    }

    @media (max-width:768px){
      .my_profile_settings_tab_payment_history_table th,
      .my_profile_settings_tab_payment_history_table td{
        padding:10px 6px;
        font-size:14px;
      }
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="my_profile_settings_tab_payment_history_wrapper max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
      <h1 class="text-2xl font-semibold">Payment history</h1>
      <button id="my_profile_settings_tab_payment_history_update_btn"
              class="my_profile_settings_tab_payment_history_update_btn">Update billing info</button>
    </div>

    <div class="overflow-x-auto border border-[var(--my_profile_settings_tab_payment_history_border)] rounded-[var(--my_profile_settings_tab_payment_history_radius)]">
      <table class="my_profile_settings_tab_payment_history_table w-full">
        <thead>
          <tr>
            <th>DATE</th>
            <th>CLASS TYPE</th>
            <th>SUBJECT</th>
            <th>TUTOR</th>
            <th>HOURS</th>
            <th>AMOUNT</th>
            <th>DOWNLOAD ALL</th>
          </tr>
        </thead>
        <tbody id="my_profile_settings_tab_payment_history_body">
          <!-- Sample Rows -->
          <tr>
            <td>Oct 2, 2025</td>
            <td>Group</td>
            <td>English</td>
            <td>Daniela C.</td>
            <td>4</td>
            <td>$40</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Aug 17, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Connie</td>
            <td>4</td>
            <td>$59.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Aug 15, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Priscilla</td>
            <td>4</td>
            <td>$79.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jul 20, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Regina</td>
            <td>4</td>
            <td>$109.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jul 18, 2025</td>
            <td>Group</td>
            <td>English</td>
            <td>Wendy</td>
            <td>4</td>
            <td>$49.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jul 10, 2025</td>
            <td>Group</td>
            <td>English</td>
            <td>Kristin</td>
            <td>4</td>
            <td>$99.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jun 22, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Esther</td>
            <td>4</td>
            <td>$89.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jun 20, 2025</td>
            <td>Group</td>
            <td>English</td>
            <td>Colleen</td>
            <td>4</td>
            <td>$69.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jun 12, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Courtney</td>
            <td>4</td>
            <td>$119.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
          <tr>
            <td>Jun 11, 2025</td>
            <td>1:1</td>
            <td>English</td>
            <td>Judith</td>
            <td>4</td>
            <td>$129.99</td>
            <td><a href="#" class="my_profile_settings_tab_payment_history_link">Get receipt</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function my_profile_settings_tab_payment_history_init(){
      $('#my_profile_settings_tab_payment_history_update_btn').on('click', function(){
        alert('Redirect to billing info update page (demo)');
      });

      $('.my_profile_settings_tab_payment_history_link').on('click', function(e){
        e.preventDefault();
        alert('Receipt download started (demo).');
      });
    }
    $(document).ready(my_profile_settings_tab_payment_history_init);
  </script>

</body>
</html>
