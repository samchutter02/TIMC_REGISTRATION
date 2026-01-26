<?php
if (file_exists(__DIR__ . "/.reg-closed")) {
    include "registration-closed.php";
    exit();
}

//============================================
// to kill/activate registration, simply upload an empty sentinel file (no file type) called exactly ".reg-closed" to the server (include the dot at the beginning)
// this will activate "registration.closed.php" which displays a message and allows a redirect to the TIMC website
//===========================================
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tucson International Mariachi Conference Registration</title>
  <style>
    :root {
      --primary:       #b22222;       
      --primary-dark:  #8b1a1a;      
      --primary-light: #c8102e;       
      --secondary:     #006400;       
      --accent-gold:   #d4af37;       
      --bg:            #fdfdfd;       
      --card:          #ffffff;       
      --text:          #1a1a1a;       
      --text-light:    #444444;       
      --border:        #d0d0d0;      
      --error:         #b22222;       
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
      margin: 0;
      padding: 16px;
      line-height: 1.6;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
    }

    header {
      text-align: center;
      margin: 28px 0 28px;
    }

    header img {
      max-width: 100%;
      height: auto;
      width: min(620px, 90vw);
      border-radius: 10px;
    }

    .header-info {
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--primary);
      margin: 20px 0 36px;
      letter-spacing: 0.8px;
      text-align: center;
      text-transform: uppercase;
    }

    h2 {
      color: var(--primary);
      font-size: 1.8rem;
      font-weight: 800;
      margin: 0 0 1.4rem;
      padding-bottom: 0.6rem;
      border-bottom: 3px solid var(--primary-light);
      letter-spacing: 0.5px;
    }

    .step-counter {
      text-align: center;
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--text-light);
      margin-bottom: 1.8rem;
    }

    .card {
      background: var(--card);
      border-radius: 12px;
      box-shadow: 0 6px 22px rgba(0,0,0,0.08);
      padding: 28px;
      margin-bottom: 36px;
      border: 1px solid rgba(178,34,34,0.08);
    }

    .radio-group {
      display: flex;
      flex-wrap: wrap;
      gap: 28px;
      margin: 14px 0;
    }

    .radio-group label {
      font-size: 1.1rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
    }

    input[type="radio"] {
      width: 1.3em;
      height: 1.3em;
    }

    label > input[type="text"],
    input[type="text"],
    input[type="tel"],
    input[type="number"],
    select {
      width: 100%;
      padding: 13px 15px;
      font-size: 1.05rem;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: #fffefb;
      transition: border-color 0.25s, box-shadow 0.25s;
    }

    input:focus, select:focus {
      outline: none;
      border-color: var(--primary-light);
      box-shadow: 0 0 0 4px rgba(184,16,46,0.18); 
    }

    table.form-top {
      width: 100%;
      border-collapse: collapse;
    }

    table.form-top tr {
      border-bottom: 1px solid var(--border);
    }

    table.form-top td {
      padding: 15px 12px;
      vertical-align: middle;
    }

    table.form-top td:first-child {
      font-weight: 700;
      color: var(--text-light);
      width: 38%;
      min-width: 150px;
    }

    @media (max-width: 640px) {
      table.form-top td {
        display: block;
        width: 100%;
        padding: 12px 0;
      }
      table.form-top td:first-child {
        padding-bottom: 5px;
        font-size: 1rem;
      }
    }

    .participant-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.92rem;
      background: var(--card);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 14px rgba(0,0,0,0.06);
    }

    .participant-table th,
    .participant-table td {
      padding: 8px 6px;
      border: 1px solid var(--border);
      text-align: center;
      white-space: nowrap;
      text-overflow: ellipsis;
      font-size: 0.92rem;
    }

    .participant-table th {
      background: #fef5f5; 
      font-weight: 700;
      color: var(--text);
      white-space: normal;
    }

    .row-even { background: #fffafa; }
    .row-odd  { background: #ffffff; }

    .controls {
      margin: 28px 0 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 18px;
      align-items: center;
    }

    button {
      padding: 13px 26px;
      font-size: 1.1rem;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.25s;
    }

    button.primary {
      background: var(--primary);
      color: white;
    }

    button.primary:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(178,34,34,0.3);
    }

    button.secondary {
      background: var(--secondary);
      color: white;
    }

    button.secondary:hover {
      background: #004d00;
    }

    button.add {
      background: var(--secondary);
      color: white;
      font-size: 1.05rem;
      padding: 11px 18px;
    }

    button.add:hover {
      background: #004d00;
    }

    button.remove-btn {
      background: #dc2626;
      color: white;
      padding: 6px 12px;
      font-size: 0.9rem;
      font-weight: 600;
      border-radius: 6px;
    }

    button.remove-btn:hover {
      background: #b91c1c;
    }

    .form-navigation {
      text-align: center;
      margin: 44px 0 28px;
      display: flex;
      justify-content: center;
      gap: 24px;
      flex-wrap: wrap;
    }

    .hidden { display: none !important; }

    .color-bar {
      width: 100%;
      height: 20px;                  
      background-image: url('img/color-bars.png');
      background-repeat: repeat-x;   
      background-position: top left;
      background-size: auto 20px;   
      margin-bottom: 2rem;
      padding: 0;
      border: none;
    }

    footer {
      text-align: center;
      padding: 28px;
      color: var(--text-light);
      font-size: 0.97rem;
      border-top: 1px solid var(--border);
      margin-top: 52px;
    }

    #duration-warning {
      color: var(--error);
      font-weight: 700;
    }

    @media (max-width: 640px) {
      body { padding: 12px; }
      h2 { font-size: 1.55rem; }
      .card { padding: 20px; }
      .participant-table th, .participant-table td { font-size: 0.9rem; padding: 9px 7px; }
      .participant-table { font-size: 0.94rem; min-width: 780px;}
      .form-navigation button { padding: 13px 22px; font-size: 1.05rem; }
      .participant-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <header>
      <div class="color-bar"></div>
      <img src="img/header_image.jpg" 
          alt="Tucson International Mariachi Conference Logo">
    </header>

    <div class="header-info">
      2026 REGISTRATION FORM
    </div>

    <form method="post" action="process.php" id="regForm">

      <!-- PAGE 1 -->
      <div class="card" id="step1">
        <h2>1. Registration Information</h2>
        <div style="margin: 1.5rem 0;">
          <strong>This registration is for:</strong>
          <div class="radio-group">
            <label><input type="radio" name="registration_type" value="group" checked required> Group</label>
            <label><input type="radio" name="registration_type" value="individual"> Individual</label>
          </div>
        </div>

        <input type="hidden" name="group_type" id="group_type_hidden" value="">

        <table class="form-top">
          <tr>
            <td><strong id="registrant-name-label">Group Name:</strong></td>
            <td colspan="3"><input type="text" name="group_name" id="registrant-name" required></td>
          </tr>
          <tr>
            <td><strong>Workshop Type:</strong></td>
            <td colspan="3">
              <div class="radio-group">
                <label><input type="radio" name="workshop_type" value="Mariachi" required> Mariachi</label>
                <label><input type="radio" name="workshop_type" value="Folklorico"> Folklorico</label>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong id="hotel-question-label">Will you / your group be staying at a hotel during the conference?</strong></td>
            <td colspan="3">
              <div class="radio-group">
                <label><input type="radio" name="hotel" value="yes" required> Yes</label>
                <label><input type="radio" name="hotel" value="no" required> No</label>
              </div>

              <div id="hotel-details-container" style="margin-top: 20px; display: none; padding: 16px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                <div style="margin-bottom: 16px;">
                  <label for="hotel_name"><strong>Hotel Name:</strong></label>
                  <input type="text" id="hotel_name" name="hotel_name" placeholder="e.g., Ramada by Wyndham Tucson, DoubleTree by Hilton, etc." style="margin-top: 6px;">
                </div>
                <div>
                  <label for="hotel_nights"><strong>How many nights will you / your group be staying?</strong></label>
                  <input type="number" id="hotel_nights" name="hotel_nights" min="1" max="30" style="width: 120px; margin-top: 6px;" placeholder="e.g., 3">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>Group Type:</strong></td>
            <td colspan="3">
              <div class="radio-group">
                <label><input type="radio" name="group_type" value="School"> School</label>
                <label><input type="radio" name="group_type" value="Community"> Community</label>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>School Name:</strong></td>
            <td><input type="text" name="school_name"></td>
          </tr>
          <tr>
            <td><strong>Would this group like to perform in Showcase?</strong></td>
            <td>
              <div class="radio-group">
                <label><input type="radio" name="showcase_performance" value="Yes" required> Yes</label>
                <label><input type="radio" name="showcase_performance" value="No"> No</label>
              </div>
            </td>
          </tr>
          <tr id="competition-exclusion-row" class="hidden">
            <td><strong>Would this group like to be EXCLUDED from competition?</strong></td>
            <td colspan="3">
              <div class="radio-group">
                <label><input type="radio" name="competition_exclusion" value="yes"> Yes - please <strong><u>exclude</u></strong> us</label>
                <label><input type="radio" name="competition_exclusion" value="no"> No - we <strong><u>want to</u></strong> participate</label>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>Would this group like to perform in Garibaldi?</strong></td>
            <td>
              <div class="radio-group">
                <label><input type="radio" name="garibaldi_performance" value="yes" required> Yes</label>
                <label><input type="radio" name="garibaldi_performance" value="no"> No</label>
              </div>
            </td>
          </tr>
        </table>

        <div class="director-question-section" style="margin-top: 1.3rem; padding: 16px; background: #f0fdf4; border-radius: 10px; border: 1px solid #bbf7d0;">
          <strong>Are you the director of this group?</strong>
          <div class="radio-group" style="margin-top: 12px;">
            <label><input type="radio" name="is_director" value="yes" checked required> Yes,<b>I am</b> the director of this group</label>
            <label><input type="radio" name="is_director" value="no"> No,<b>I am not</b> the director of this group</label>
          </div>

          <div id="registrant-fields" style="display: none; margin-top: 1.5rem;">
            <table class="form-top" style="margin-top: 12px;">
              <tr>
                <td><strong>Your First Name:</strong></td>
                <td><input type="text" name="user_first_name" id="user_first_name"></td>
                <td><strong>Your Last Name:</strong></td>
                <td><input type="text" name="user_last_name" id="user_last_name"></td>
              </tr>
              <tr>
                <td><strong>Your Email:</strong></td>
                <td colspan="3"><input type="text" name="user_email"></td>
              </tr>
              <tr>
                <td><strong>Your Day Phone:</strong></td>
                <td><input type="tel" name="user_phone"></td>
                <td></td><td></td>
              </tr>
            </table>
            <p style="font-size: 0.92em; color: #555; margin-top: 8px;">
              The director's information (name, email, phone) is still required below.
            </p>
          </div>
        </div>
        
      </div>

      <!-- PAGE 2 -->
      <div class="card" id="step2">
        <h2>2. Contact & Performance Preferences</h2>
        <table class="form-top">
          <tr>
            <td><strong id="director-first-label">Director First Name:</strong></td>
            <td><input type="text" name="director_first" placeholder="First" required></td>
            <td><strong id="director-last-label">Director Last Name:</strong></td>
            <td><input type="text" name="director_last" placeholder="Last" required></td>
          </tr>
          <tr>
            <td><strong id="email-label">Director Email:</strong></td>
            <td colspan="3"><input type="text" name="email" id="email-field" required></td>
          </tr>
          <tr>
            <td><strong id="address-label">Director Address:</strong></td>
            <td colspan="3"><input type="text" name="street_address" id="street-address-field" required></td>
          </tr>
          <tr>
            <td><strong id="city-label">City:</strong></td>
            <td><input type="text" name="city" id="city-field" required></td>
            <td><strong id="state-label">State:</strong></td>
            <td>
              <select name="state" id="state-field" required>
                <option value="">Select...</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><strong id="zip-label">Zip:</strong></td>
            <td><input type="text" name="zip_code" id="zip-field" required></td>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td><strong id="cell-phone-label">Director Cell Phone:</strong></td>
            <td><input type="tel" name="cell_phone" id="cell-phone-field" required></td>
            <td><strong>Day Phone:</strong></td>
            <td><input type="tel" name="daytime_phone"></td>
          </tr>
          <tr>
            <td colspan="4" style="padding-top: 1.5rem;">
              <strong>Add an Assistant Director?</strong>
              <div class="radio-group" style="margin-top: 12px;">
                <label><input type="radio" name="has_assistant_director" value="yes"> Yes</label>
                <label><input type="radio" name="has_assistant_director" value="no"> No</label>
              </div>
            </td>
          </tr>

          <tbody id="assistant-director-fields" style="display: none;">
            <tr>
              <td><strong>Assistant Director First Name:</strong></td>
              <td><input type="text" name="d2_first_name"></td>
              <td><strong>Assistant Last Name:</strong></td>
              <td><input type="text" name="d2_last_name"></td>
            </tr>
            <tr>
              <td><strong>Assistant Director Cell Phone:</strong></td>
              <td><input type="tel" name="d2_cell_phone"></td>
              <td><strong>Assistant Day Phone:</strong></td>
              <td><input type="tel" name="d2_daytime_phone"></td>
            </tr>
            <tr>
              <td><strong>Assistant Director Email:</strong></td>
              <td><input type="text" name="d2_email"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!--PAGE 3-->
      <div class="card" id="step3">
        <h2 id="participants-header">3. Participants</h2>

        <table class="participant-table" id="participants">
          <h4 style="color: black; font-weight: light;" id="enter-participants-text">Enter participants below:</h4>
          <thead>
            <tr>
              <th>•</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th style="width: 100px;">Age</th>
              <th>Gender</th>
              <th>Grade</th>
              <th>Race</th>
              <th>Instrument / Class</th>
              <th>Level</th>
              <th>Cost</th>
              <th>–––</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <button type="button" class="add" onclick="addRow()" style="margin-top: 1rem;" id="add-participant-btn">+ Add Participant</button>

        <div id="showcase-songs-section" class="hidden" style="margin-top: 40px; padding-top: 24px; border-top: 2px solid #e0e0e0;">
          <h2 style="margin-bottom: 16px; color: #1e40af;">Showcase Performance - Song List</h2>
          <p style="margin: 0 0 20px 0; color: #555; font-size: 0.98em;">
            Please enter up to 3 songs for your showcase performance.<br>
            <strong>Total combined length must not exceed 9 minutes (540 seconds).</strong>
          </p>

          <table class="participant-table" style="margin-bottom: 20px;">
            <thead>
              <tr>
                <th style="width: 40px; text-align:center;">#</th>
                <th style="text-align:left;">Song Title</th>
                <th style="width: 180px; text-align:center;">Length</th>
                <th style="width: 120px; text-align:center;">Seconds</th>
              </tr>
            </thead>
            <tbody id="songs-tbody"></tbody>
          </table>

          <div style="font-size: 1.1em; font-weight: bold; text-align: right; padding-right: 12px;">
            Total duration: <span id="total-song-duration">0:00</span> (<span id="total-seconds">0</span> seconds)
            <span id="duration-warning" style="color: var(--error); margin-left: 16px; display: none;">
              → Exceeds 9 minutes / 540 seconds
            </span>
          </div>

          <input type="hidden" name="showcase_total_seconds" id="showcase_total_seconds" value="0">
        </div>

        <input type="hidden" name="total_cost" id="total_cost" value="0">
      </div>

      <div class="card" id="step4" style="margin: 40px 0 24px; padding: 24px; background: #f0f9ff; border-radius: 12px; border: 1px solid #bae6fd;">
        <h2>4. Payment Information</h2>
          <div class="radio-group" style="font-size: 1.1rem;">
            <label style="margin-right: 48px;">
              <input type="radio" name="payment_method" value="credit_card" required checked>
              Pay with Credit Card (via Stripe)
            </label>
            <label>
              <input type="radio" name="payment_method" value="purchase_order">
              Pay by Purchase Order / Invoice
            </label>
            <p id="purchase-order-info" style="margin-top: 16px; font-size: 0.95rem; color: #475569;">
            <strong>Purchase Order:</strong> Your group will receive a confirmation email with invoice details. 
            No payment is processed now - please submit PO/payment within the stated deadline.
            </p>
          </div>
      </div>

      <!-- Nav-->
      <div class="form-navigation">
        <button type="submit" id="submitBtn" class="primary">Review & Continue to Payment →</button>
      </div>
    </form>

    <footer>
      Tel: (520) 838-3913 | Email: info@tucsonmariachi.org
      <div class="color-bar" style="margin-top: 1rem; margin-bottom: 0rem;"></div>
    </footer>

  </div>

  <script>
let rowCounter = 0;

// ───────────────
//row management
// ────────────────
function addRow() {
      const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
      if (isIndividual && rowCounter >= 1) {
        alert("Individual registration allows only one participant.");
        return;
      }

      rowCounter++;
      const tbody = document.querySelector('#participants tbody');
      const tr = document.createElement('tr');
      tr.className = (rowCounter % 2 === 0) ? 'row-even' : 'row-odd';

      tr.innerHTML = `
        <td>${rowCounter}</td>
        <td><input type="text" name="performers[${rowCounter}][first_name]" required></td>
        <td><input type="text" name="performers[${rowCounter}][last_name]" required></td>
        <td><input type="number" name="performers[${rowCounter}][age]" min="1" max="99" required></td>
        <td>
          <select name="performers[${rowCounter}][gender]" required>
            <option value="">-</option><option>Male</option><option>Female</option>
          </select>
        </td>
        <td>
          <select name="performers[${rowCounter}][grade]" required>
            <option value="">-</option>
            <option>Elementary School</option><option>Middle School</option><option>High School</option><option>College</option><option>N/A</option>
          </select>
        </td>
        <td>
          <select name="performers[${rowCounter}][race]" required>
            <option value="">-</option>
            <option>African American</option><option>Asian American</option><option>Hispanic</option>
            <option>Mexican American</option><option>Native American</option><option>White</option><option>Other</option>
          </select>
        </td>
        <td>
          <select name="performers[${rowCounter}][class]" class="instrument" required>
            <option value="">-</option>
            <option>Guitar</option><option>Guitarron</option><option>Harp</option>
            <option>Trumpet</option><option>Vihuela</option><option>Violin</option><option>Voice</option>
          </select>
        </td>
        <td>
          <select name="performers[${rowCounter}][level]" class="level" required>
            <option value="">-</option>
            <option value="I">I ($115)</option>
            <option value="II">II ($115)</option>
            <option value="III">III ($115)</option>
            <option value="Master">Master ($165)</option>
          </select>
        </td>
        <td class="cost-cell">$0.00</td>
        <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
      `;

      tbody.appendChild(tr);

      const instrSelect = tr.querySelector('.instrument');
      const levelSelect = tr.querySelector('.level');
      const costCell = tr.querySelector('.cost-cell');

      function updateLevelOptions() {
        const isVoice = instrSelect.value === 'Voice';
        const currentLevel = levelSelect.value;
        levelSelect.innerHTML = `
          <option value="">-</option>
          <option value="I">I ($115)</option>
          <option value="II">II ($115)</option>
          <option value="III">III ($115)</option>
          <option value="Master">Master ($${isVoice ? '115' : '165'})</option>
        `;
        if (["I", "II", "III", "Master"].includes(currentLevel)) levelSelect.value = currentLevel;
      }

      function updateCost() {
        const instr = instrSelect.value;
        const lvl = levelSelect.value;
        let cost = 0;
        if (["I", "II", "III"].includes(lvl)) cost = 115;
        else if (lvl === "Master") cost = (instr === "Voice") ? 115 : 165;
        costCell.textContent = `$${cost}.00`;
        calculateGrandTotal();
      }

      instrSelect.addEventListener('change', () => { updateLevelOptions(); updateCost(); });
      levelSelect.addEventListener('change', updateCost);
      updateLevelOptions();
    }

function removeRow(btn) {
  const tr = btn.closest('tr');
  tr.remove();
  rowCounter--;

  // Re-number the rows
  document.querySelectorAll('#participants tbody tr').forEach((row, index) => {
    row.querySelector('td:first-child').textContent = index + 1;
    row.className = ((index + 1) % 2 === 0) ? 'row-even' : 'row-odd';
  });

  calculateGrandTotal();
}

    function calculateGrandTotal() {
      let total = 0;
      document.querySelectorAll('.cost-cell').forEach(cell => {
        total += parseFloat(cell.textContent.replace(/[$\s]/g, '')) || 0;
      });
      document.getElementById('total_cost').value = total;
}

function validateShowcaseDuration() {
  const wantsShowcase = document.querySelector('input[name="showcase_performance"]:checked')?.value === 'yes';
  if (!wantsShowcase) return true;
  const totalSec = parseInt(document.getElementById('showcase_total_seconds')?.value) || 0;
  if (totalSec > 540) {
    alert("Showcase total duration exceeds 9 minutes (540 seconds). Please adjust the song lengths before continuing.");
    return false;
  }
  return true;
}

// ────────────────────────────
// visibility helpers
// ────────────────────────────
const showcaseRadios = document.querySelectorAll('input[name="showcase_performance"]');
const exclusionRow = document.getElementById('competition-exclusion-row');
function toggleCompetitionExclusion() {
  const wantsShowcase = document.querySelector('input[name="showcase_performance"]:checked')?.value === 'Yes';
  
  if (wantsShowcase) {
    exclusionRow.classList.remove('hidden');
  } else {
    exclusionRow.classList.add('hidden');
    exclusionRow.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
  }
}

const hotelRadios = document.querySelectorAll('input[name="hotel"]');
const hotelDetails = document.getElementById('hotel-details-container');
const hotelQuestionLabel = document.getElementById('hotel-question-label');

function toggleHotelDetails() {
  const selected = document.querySelector('input[name="hotel"]:checked');
  const show = selected && selected.value === 'yes';
  
  hotelDetails.style.display = show ? 'block' : 'none';
  
  if (!show) {
    document.getElementById('hotel_name').value = '';
    document.getElementById('hotel_nights').value = '';
  }
}


const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
const poInfo = document.getElementById('purchase-order-info');

function togglePOInfo() {
  const selectedMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
  poInfo.style.display = (selectedMethod === 'purchase_order') ? 'block' : 'none';
}
paymentRadios.forEach(radio => radio.addEventListener('change', () => {
  togglePOInfo();
  updatePaymentOptions(); // To prevent selection if individual
}));
togglePOInfo();


// ───────────────────────
//Showcase song management
// ─────────────────────────
const songsSection = document.getElementById('showcase-songs-section');
const songsTbody = document.getElementById('songs-tbody');
const totalDurationEl = document.getElementById('total-song-duration');
const totalSecondsEl = document.getElementById('total-seconds');
const warningEl = document.getElementById('duration-warning');
const totalSecondsHidden = document.getElementById('showcase_total_seconds');

function generateSongRows() {
  songsTbody.innerHTML = '';
  for (let i = 1; i <= 3; i++) {
    const tr = document.createElement('tr');
    tr.className = (i % 2 === 0) ? 'row-even' : 'row-odd';

    tr.innerHTML = `
      <td style="text-align:center;">${i}</td>
      <td>
        <input type="text" name="showcase_songs[${i}][title]" 
               placeholder="Enter song title" style="width:100%;" maxlength="120">
      </td>
      <td style="text-align:center; font-family: monospace;" id="formatted-${i}">
        00:00
      </td>
      <td style="text-align:center;">
        <input type="number" name="showcase_songs[${i}][seconds]" 
               class="song-seconds" min="0" max="540" step="1" value="0"
               style="width:90px; text-align:center;">
      </td>
    `;
    songsTbody.appendChild(tr);

    const input = tr.querySelector('.song-seconds');
    input.addEventListener('input', updateFromSeconds);
    input.addEventListener('change', updateFromSeconds);
  }
  updateTotalDuration();
}

function toggleShowcaseSongs() {
  const wantsShowcase = document.querySelector('input[name="showcase_performance"]:checked')?.value === 'Yes';
  if (wantsShowcase) {
    songsSection.classList.remove('hidden');
    if (songsTbody.children.length === 0) {
      generateSongRows();
    }
  } else {
    songsSection.classList.add('hidden');
  }
}

function secondsToMMSS(total) {
  const min = Math.floor(total / 60);
  const sec = total % 60;
  return `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
}

function updateFromSeconds(e) {
  const row = e.target.closest('tr');
  const formattedCell = row.querySelector('[id^="formatted-"]');
  const seconds = parseInt(e.target.value) || 0;
  formattedCell.textContent = secondsToMMSS(seconds);
  updateTotalDuration();
}

function updateTotalDuration() {
  let totalSec = 0;
  document.querySelectorAll('.song-seconds').forEach(el => {
    totalSec += parseInt(el.value) || 0;
  });

  totalDurationEl.textContent = secondsToMMSS(totalSec);
  totalSecondsEl.textContent = totalSec;
  totalSecondsHidden.value = totalSec;

  if (totalSec > 540) {
    warningEl.style.display = 'inline';
    totalDurationEl.style.color = '#d32f2f';
    totalSecondsEl.style.color = '#d32f2f';
  } else {
    warningEl.style.display = 'none';
    totalDurationEl.style.color = '';
    totalSecondsEl.style.color = '';
  }
}

// ────────────────────────────
//Main form state management
// ────────────────────────────
function updateHotelLabel() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
  if (hotelQuestionLabel) {
    hotelQuestionLabel.textContent = isIndividual 
      ? "Will you be staying at a hotel during the conference?"
      : "Will you / your group be staying at a hotel during the conference?";
  }
}

function updateLabelsForIndividual() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';

  // Update contact field labels
  document.getElementById('director-first-label').textContent = isIndividual ? "Your First Name:" : "Director First Name:";
  document.getElementById('director-last-label').textContent  = isIndividual ? "Your Last Name:"   : "Director Last Name:";
  document.getElementById('email-label').textContent          = isIndividual ? "Your Email:"       : "Director Email:";
  document.getElementById('address-label').textContent        = isIndividual ? "Your Address:"     : "Director Address:";
  document.getElementById('city-label').textContent           = isIndividual ? "Your City:"        : "City:";
  document.getElementById('state-label').textContent          = isIndividual ? "Your State:"       : "State:";
  document.getElementById('zip-label').textContent            = isIndividual ? "Your Zip:"         : "Zip:";
  document.getElementById('cell-phone-label').textContent     = isIndividual ? "Your Cell Phone:"  : "Director Cell Phone:";
}

function setGroupTypeForIndividual() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
  const groupTypeHidden = document.getElementById('group_type_hidden');
  const groupTypeVisibleRadios = document.querySelectorAll('input[name="group_type"]:not(#group_type_hidden)');

  if (isIndividual) {
    groupTypeHidden.value = 'Individual';
    groupTypeVisibleRadios.forEach(r => {
      r.checked = false;
      r.disabled = true;
    });
  } else {
    groupTypeHidden.value = '';
    groupTypeVisibleRadios.forEach(r => {
      r.disabled = false;
    });
  }
}

function updateParticipantText() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
  const participantsHeader = document.getElementById('participants-header');
  const enterParticipantsText = document.getElementById('enter-participants-text');
  const addParticipantBtn = document.getElementById('add-participant-btn');

  if (participantsHeader) {
    participantsHeader.textContent = isIndividual ? '3. Participant' : '3. Participants';
  }

  if (enterParticipantsText) {
    enterParticipantsText.textContent = isIndividual ? 'Enter participant below:' : 'Enter participants below:';
  }

  if (addParticipantBtn) {
    addParticipantBtn.textContent = '+ Add Participant';
  }
}

function updateFormForIndividual() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';

  setGroupTypeForIndividual();
  updateLabelsForIndividual();
  updateParticipantText();

  if (isIndividual) {
    const rows = document.querySelectorAll('#participants tbody tr');
    for (let i = 1; i < rows.length; i++) {
      rows[i].remove();
      rowCounter--;
    }
  }

  const groupOnlyRequiredFields = [
      ...document.querySelectorAll('input[name="showcase_performance"]'),
      ...document.querySelectorAll('input[name="garibaldi_performance"]'),
      ...document.querySelectorAll('input[name="is_director"]'),
      document.querySelector('input[name="director_first"]'),
      document.querySelector('input[name="director_last"]'),
      document.querySelector('input[name="email"]'),     
      document.querySelector('input[name="street_address"]'),
      document.querySelector('input[name="city"]'),
      document.querySelector('select[name="state"]'),
      document.querySelector('input[name="zip_code"]'),
      document.querySelector('input[name="cell_phone"]'),
      
      document.querySelector('input[name="has_assistant_director"]'),
  ].filter(el => el !== null);

  groupOnlyRequiredFields.forEach(field => {
      if (isIndividual) {
          field.removeAttribute('required');
      } else {
          field.setAttribute('required', 'required');
      }
  });

  const toHide = [
      document.querySelector('tr:has(input[name="garibaldi_performance"])'),
      document.querySelector('tr:has(input[name="group_type"]):not(:has(#group_type_hidden))'),
      document.querySelector('tr:has(input[name="showcase_performance"])'),
      document.getElementById('competition-exclusion-row'),
      document.querySelector('tr:has(input[name="school_name"])'),
      document.querySelector('.director-question-section'),
      document.querySelector('tr:has(input[name="director_first"])'),
      document.querySelector('tr:has(input[name="has_assistant_director"])'),
      document.getElementById('assistant-director-fields')
  ].filter(el => el);

  toHide.forEach(el => {
      el.style.display = isIndividual ? 'none' : '';
      if (isIndividual) {
          el.querySelectorAll('input, select').forEach(field => {
              if (field.type === 'radio' || field.type === 'checkbox') {
                  field.checked = false;
              } else if (field.tagName === 'SELECT') {
                  field.selectedIndex = 0;
              } else {
                  field.value = '';
              }
          });
      }
  });

  const songsSection = document.getElementById('showcase-songs-section');
  if (songsSection) {
      songsSection.classList.toggle('hidden', isIndividual);
      
      if (isIndividual && !songsSection.classList.contains('hidden')) {
          document.querySelectorAll('#songs-tbody input').forEach(inp => {
              inp.value = '';
          });
          updateTotalDuration();
      }
  }

  const participantHeader = document.querySelector('#participants thead tr');
  if (participantHeader && isIndividual) {
      participantHeader.querySelectorAll('th')[9].textContent = 'Fee'; 
  }

  updateHotelLabel(); 

  updatePaymentOptions();
}

function updatePaymentOptions() {
  const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
  const poLabel = document.querySelector('label:has(input[value="purchase_order"])');
  const poRadio = document.querySelector('input[value="purchase_order"]');
  const ccRadio = document.querySelector('input[value="credit_card"]');
  const poInfo = document.getElementById('purchase-order-info');

  if (isIndividual) {
    if (poLabel) poLabel.style.display = 'none';
    if (poRadio) {
      poRadio.disabled = true;
      if (poRadio.checked) {
        ccRadio.checked = true;
      }
    }
    if (poInfo) poInfo.style.display = 'none';
  } else {
    if (poLabel) poLabel.style.display = '';
    if (poRadio) poRadio.disabled = false;
  }
  togglePOInfo();
}

// ────────────────
// event listeners
// ──────────────────
document.querySelectorAll('input[name="registration_type"]').forEach(radio => {
  radio.addEventListener('change', () => {
    updateFormForIndividual();
  });
});

showcaseRadios.forEach(radio => {
  radio.addEventListener('change', toggleShowcaseSongs);
});

showcaseRadios.forEach(radio => {
  radio.addEventListener('change', toggleCompetitionExclusion);
});

hotelRadios.forEach(radio => radio.addEventListener('change', toggleHotelDetails));

document.getElementById('regForm').addEventListener('submit', function(e) {
    const registrationType = document.querySelector('input[name="registration_type"]:checked')?.value;
  
    if (registrationType === 'individual') {
        const firstRow = document.querySelector('#participants tbody tr');
        if (!firstRow) {
            alert("Please add at least one participant for individual registration.");
            e.preventDefault();
            return;
        }
        
        const participantFirst = firstRow.querySelector('input[name*="][first_name]"]')?.value.trim()  || '';
        const participantLast  = firstRow.querySelector('input[name*="][last_name]"]')?.value.trim()   || '';
        const participantFull = [participantFirst, participantLast].filter(Boolean).join(' ').trim();
        
        if (!participantFull) {
            alert("Please enter first and last name for the participant.");
            e.preventDefault();
            return;
        }
        
        const groupInput = document.getElementById('registrant-name');
        const enteredFullName = groupInput.value.trim();
        
        if (!enteredFullName) {
            alert("Please enter the individual's full name.");
            e.preventDefault();
            return;
        }
        
        //split the entered full name for director
        const nameParts = enteredFullName.split(/\s+/);
        const lastName = nameParts.pop() || '';
        const firstName = nameParts.join(' ') || '';
        
        document.querySelector('input[name="director_first"]').value = firstName;
        document.querySelector('input[name="director_last"]').value = lastName;
        
        //Set group_name to [INDIVIDUAL] - participant full name
        groupInput.value = `[INDIVIDUAL] - ${participantFull}`;
    }
});

// ────────────────
// DOMContentLoaded
// ─────────────────
document.addEventListener('DOMContentLoaded', () => {
  toggleCompetitionExclusion();
  toggleHotelDetails();

  const radios = document.querySelectorAll('input[name="registration_type"]');
  const label = document.getElementById('registrant-name-label');
  const input = document.getElementById('registrant-name');

  const isDirectorRadios = document.querySelectorAll('input[name="is_director"]');
  const registrantFields = document.getElementById('registrant-fields');

  function toggleRegistrantFields() {
    const isDirector = document.querySelector('input[name="is_director"]:checked')?.value === 'yes';
    registrantFields.style.display = isDirector ? 'none' : 'block';

    if (isDirector) {
      registrantFields.querySelectorAll('input').forEach(el => el.value = '');
    }
  }

  const schoolNameRow = document.querySelector('tr:has(input[name="school_name"])');
const groupTypeRadios = document.querySelectorAll('input[name="group_type"]');

function toggleSchoolNameField() {
  const selectedType = document.querySelector('input[name="group_type"]:checked')?.value;
  
  if (schoolNameRow) {
    if (selectedType === 'School') {
      schoolNameRow.style.display = '';
      schoolNameRow.querySelector('input').setAttribute('required', 'required');
    } else {
      schoolNameRow.style.display = 'none';
      schoolNameRow.querySelector('input').removeAttribute('required');
      schoolNameRow.querySelector('input').value = '';
    }
  }
}

// Initial check
toggleSchoolNameField();

// Listen for changes
groupTypeRadios.forEach(radio => {
  radio.addEventListener('change', toggleSchoolNameField);
});

  toggleRegistrantFields();
  isDirectorRadios.forEach(radio => {
    radio.addEventListener('change', toggleRegistrantFields);
  });

  const assistantRadios = document.querySelectorAll('input[name="has_assistant_director"]');
  const assistantFields = document.getElementById('assistant-director-fields');

  function toggleAssistantFields() {
    const hasAssistant = document.querySelector('input[name="has_assistant_director"]:checked')?.value === 'yes';
    assistantFields.style.display = hasAssistant ? '' : 'none';
    
    if (!hasAssistant) {
      assistantFields.querySelectorAll('input').forEach(el => el.value = '');
    }
  }

  assistantRadios.forEach(radio => radio.addEventListener('change', toggleAssistantFields));

  toggleAssistantFields();

  function updateLabelAndPrefix() {
    const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
    if (isIndividual) {
        label.innerHTML = "Your Full Name:<br><small>(whoever is filling out this form)</small>";
    } else {
        label.textContent = "Group Name:";
    }
}

  updateLabelAndPrefix();
  radios.forEach(radio => radio.addEventListener('change', updateLabelAndPrefix));

  input.addEventListener('input', () => {
    const isIndividual = document.querySelector('input[name="registration_type"]:checked')?.value === 'individual';
    if (isIndividual) ensurePrefix();
  });
  input.addEventListener('focus', ensurePrefix);

  toggleShowcaseSongs();
  updateFormForIndividual();
  addRow();
  updatePaymentOptions();
});

</script>

</body>
</html>
