<style>
  .dropdown-wrapper {
    position: relative;
    width: 280px;
  }

  .dropdown-input {
    padding: 10px 14px;
    background: #fff;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .dropdown-input:after {
    content: "▼";
    font-size: 12px;
    margin-left: 8px;
  }

  .date-dropdown-menu {
    position: absolute;
    top: 110%;
    left: 0;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    padding: 16px;
    display: none;
    z-index: 100;
  }

  .date-dropdown-menu.active {
    display: block;
  }

  .dropdown-option {
    padding: 8px 10px;
    font-size: 15px;
    cursor: pointer;
    border-radius: 6px;
  }

  .dropdown-option:hover {
    background: #f0f0f0;
  }

  .dropdown-option.selected {
    background: #f3f3f3;
    font-weight: 600;
  }

  .date-range {
    margin-top: 12px;
  }

  .date-input {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f9f9f9;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
    font-size: 14px;
    font-weight: 600;
  }

  .date-input span {
    color: #555;
    margin-right: 6px;
    font-weight: 500;
  }

  .date-input input[type="date"] {
    border: none;
    background: transparent;
    font-weight: 600;
    font-size: 14px;
    color: #000;
    outline: none;
  }

  .graph-loading,
  .graph-error {
    padding: 20px;
    text-align: center;
    color: #666;
  }

  .graph-error {
    color: #d32f2f;
  }

  .graph-error button {
    background: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
  }

  .graph-error i {
    margin-right: 8px;
  }

  #membershipChart {
    width: 100%;
    height: 400px;
  }
</style>