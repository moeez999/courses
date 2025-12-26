<style>
  /* ===== Lesson Rate Cards (stacked vertically) ===== */
  .lesson-rate-cards {
    display: flex;
    flex-direction: column;
    /* always vertical */
    gap: 12px;
    /* spacing between boxes */
    margin-top: 20px;
  }

  .lesson-rate-card {
    display: flex;
    align-items: center;
    width: 100%;
    /* take full width of sidebar */
    min-height: 60px;
    /* keep consistent height with other boxes */
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
  }

  .lesson-rate-card:hover {
    background: #f9fafb;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  }

  .lesson-rate-card .icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-right: 12px;
    color: #111;
  }

  .lesson-rate-card .rate-info {
    display: flex;
    flex-direction: column;
    font-family: 'Poppins', sans-serif;
  }

  .rate-amount {
    font-size: 15px;
    font-weight: 600;
    color: #111;
  }

  .rate-label {
    font-size: 13px;
    color: #6b7280;
  }
</style>

<div class="lesson-rate-cards">
  <div class="lesson-rate-card" id="lesson-rate-1to1">
    <div class="icon-wrap">
      <i class="fa fa-user"></i>
    </div>
    <div class="rate-info">
      <strong class="rate-amount">7 USD</strong>
      <span class="rate-label">Rate 1:1 lessons</span>
    </div>
  </div>

  <div class="lesson-rate-card" id="lesson-rate-group">
    <div class="icon-wrap">
      <i class="fa fa-users"></i>
    </div>
    <div class="rate-info">
      <strong class="rate-amount">7 USD</strong>
      <span class="rate-label">Rate Group lessons</span>
    </div>
  </div>
</div>

<script>
  //     $(document).ready(function(){
  //   // Example: click event
  //   $("#lesson-rate-1to1").on("click", function(){
  //     alert("1:1 Lesson Rate clicked!");
  //   });

  //   $("#lesson-rate-group").on("click", function(){
  //     alert("Group Lesson Rate clicked!");
  //   });
  // });
</script>