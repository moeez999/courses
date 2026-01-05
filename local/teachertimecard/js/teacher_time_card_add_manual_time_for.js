    (function($) {
      /* Data */
      const add_manual_time_for_step1_students = [{
          id: 1,
          name: 'Edwards',
          initials: 'E',
          avatar: 'https://i.pravatar.cc/96?u=edwards@latingles'
        },
        {
          id: 2,
          name: 'Daniela',
          initials: 'D',
          avatar: 'https://i.pravatar.cc/96?u=daniela@latingles'
        },
        {
          id: 3,
          name: 'Hawkins',
          initials: 'H',
          avatar: 'https://i.pravatar.cc/96?u=hawkins@latingles'
        },
        {
          id: 4,
          name: 'Lane',
          initials: 'L',
          avatar: 'https://i.pravatar.cc/96?u=lane@latingles'
        },
        {
          id: 5,
          name: 'Warren',
          initials: 'W',
          avatar: 'https://i.pravatar.cc/96?u=warren@latingles'
        },
        {
          id: 6,
          name: 'Fox',
          initials: 'F',
          avatar: 'https://i.pravatar.cc/96?u=fox@latingles'
        },
        {
          id: 7,
          name: 'Jonas',
          initials: 'J',
          avatar: 'https://i.pravatar.cc/96?u=jonas@latingles'
        },
        {
          id: 8,
          name: 'Mary',
          initials: 'M',
          avatar: 'https://i.pravatar.cc/96?u=mary@latingles'
        },
      ];
      const add_manual_time_for_step1_groups = [{
          id: 'FL-1-030423-0090'
        },
        {
          id: 'OH-12-032023-0089'
        },
        {
          id: 'NY-2-042522-0088'
        },
        {
          id: 'OH-12-032023-0089'
        }, /* example duplicate like your screenshot */
        {
          id: 'TX-1-030423-0090'
        },
        {
          id: 'CA-3-060123-0012'
        },
        {
          id: 'WA-5-021523-0042'
        },
        {
          id: 'AK-2-040423-0123'
        }
      ];

      /* State */
      let add_manual_time_for_step1_selected = null; // 'one_to_one' or 'group_lessons'
      let add_manual_time_for_step1_stage = 1;
      let add_manual_time_for_step1_student_value = null;
      let add_manual_time_for_step1_group_value = null;

      /* Modal open/close */
      function add_manual_time_for_step1_open() {
        $('#add_manual_time_for_step1_modal').css('display', 'flex').attr('aria-hidden', 'false');
        $('body').addClass('add_manual_time_for_step1_lock');
        add_manual_time_for_step1_goToStep(1, true);
      }

      function add_manual_time_for_step1_close() {
        $('#add_manual_time_for_step1_modal').fadeOut(120, function() {
          $(this).attr('aria-hidden', 'true').hide();
        });
        $('body').removeClass('add_manual_time_for_step1_lock');
      }
      $('#add_manual_time_for_step1_open_btn').on('click', add_manual_time_for_step1_open);
      $('#add_manual_time_for_step1_close_btn').on('click', add_manual_time_for_step1_close);
      $('#add_manual_time_for_step1_modal').on('click', function(e) {
        if (e.target === this) add_manual_time_for_step1_close();
      });
      $(document).on('keydown', function(e) {
        if ($('#add_manual_time_for_step1_modal').is(':visible') && e.key === 'Escape') {
          add_manual_time_for_step1_close();
        }
      });

      /* Step 1 selection */
      function add_manual_time_for_step1_select($opt) {
        $('.add_manual_time_for_step1_option').removeClass('add_manual_time_for_step1_selected').attr('aria-checked', 'false');
        $opt.addClass('add_manual_time_for_step1_selected').attr('aria-checked', 'true');
        add_manual_time_for_step1_selected = $opt.data('add_manual_time_for_step1_value');
        $('#add_manual_time_for_step1_primary_btn').prop('disabled', !add_manual_time_for_step1_selected);
      }
      $('.add_manual_time_for_step1_option').on('click', function() {
        add_manual_time_for_step1_select($(this));
      });
      $('.add_manual_time_for_step1_option').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          add_manual_time_for_step1_select($(this));
        }
      });

      /* Step change */
      function add_manual_time_for_step1_goToStep(step, resetSelection) {
        add_manual_time_for_step1_stage = step;
        const $card = $('#add_manual_time_for_step1_card');
        if (step === 1) {
          $('#add_manual_time_for_step1_step1').addClass('is-active');
          $('#add_manual_time_for_step1_step2').removeClass('is-active');
          $('#add_manual_time_for_step1_title_txt').text('Add Add Manual Time for');
          $('#add_manual_time_for_step1_primary_btn').text('Continue').prop('disabled', !add_manual_time_for_step1_selected)
            .removeClass('add_manual_time_for_step1_submit').addClass('add_manual_time_for_step1_continue');
          $card.removeClass('add_manual_time_for_step1_is_step2');
          if (resetSelection) {
            add_manual_time_for_step1_selected = null;
            $('.add_manual_time_for_step1_option').removeClass('add_manual_time_for_step1_selected').attr('aria-checked', 'false');
            $('#add_manual_time_for_step1_primary_btn').prop('disabled', true);
          }
        } else {
          // Step 2
          $('#add_manual_time_for_step1_step1').removeClass('is-active');
          $('#add_manual_time_for_step1_step2').addClass('is-active');
          $('#add_manual_time_for_step1_title_txt').text('Add Manual Time');
          $('#add_manual_time_for_step1_primary_btn').text('Submit').prop('disabled', false)
            .removeClass('add_manual_time_for_step1_continue').addClass('add_manual_time_for_step1_submit');
          $card.addClass('add_manual_time_for_step1_is_step2');

          // Show proper first field
          if (add_manual_time_for_step1_selected === 'one_to_one') {
            $('#add_manual_time_for_step1_student_field').show();
            $('#add_manual_time_for_step1_group_field').hide();
          } else {
            $('#add_manual_time_for_step1_student_field').hide();
            $('#add_manual_time_for_step1_group_field').show();
          }
        }
        add_manual_time_for_step1_closeDropdowns();
      }

      function add_manual_time_for_step1_closeDropdowns() {
        $('#add_manual_time_for_step1_student_dropdown').hide();
        $('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        $('#add_manual_time_for_step1_payable_dropdown').hide();
        $('#add_manual_time_for_step1_group_dropdown').hide();
        $('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
      }

      /* Primary (Continue/Submit) */
      $('#add_manual_time_for_step1_primary_btn').on('click', function() {
        if (add_manual_time_for_step1_stage === 1) {
          if (add_manual_time_for_step1_selected) {
            add_manual_time_for_step1_goToStep(2, false);
          }
        } else {
          const payload = {
            type: add_manual_time_for_step1_selected,
            student: add_manual_time_for_step1_student_value,
            group: add_manual_time_for_step1_group_value,
            duration: $('#add_manual_time_for_step1_duration').val(),
            attendance: $('#add_manual_time_for_step1_attendance').val(),
            payable: $('#add_manual_time_for_step1_payable_label').text(),
            amount: $('#add_manual_time_for_step1_amount').val(),
            notes: $('#add_manual_time_for_step1_notes').val()
          };
          console.log('Submit payload:', payload);
          alert('Submitted!');
          add_manual_time_for_step1_close();
        }
      });

      /* ===== Student dropdown ===== */
      function add_manual_time_for_step1_renderStudentList(list) {
        const $list = $('#add_manual_time_for_step1_student_list');
        $list.empty();
        list.forEach(s => {
          const $row = $(`
          <div class="add_manual_time_for_step1_dropdown_item" data-id="${s.id}" data-name="${s.name}">
            <div class="add_manual_time_for_step1_avatar_wrap">
              <img class="add_manual_time_for_step1_avatar_img" src="${s.avatar}" alt="${s.name}"
                onerror="this.style.display='none'; this.parentNode.querySelector('.add_manual_time_for_step1_avatar_fallback').style.display='flex';"/>
              <span class="add_manual_time_for_step1_avatar_fallback">${s.initials}</span>
            </div>
            <div class="add_manual_time_for_step1_name">${s.name}</div>
          </div>`);
          $list.append($row);
        });
      }
      add_manual_time_for_step1_renderStudentList(add_manual_time_for_step1_students);

      $('#add_manual_time_for_step1_student_search').on('input', function() {
        const q = $(this).val().toLowerCase();
        const filtered = add_manual_time_for_step1_students.filter(s => s.name.toLowerCase().includes(q));
        add_manual_time_for_step1_renderStudentList(filtered);
      });

      function add_manual_time_for_step1_toggleStudentDropdown(forceOpen) {
        const $dd = $('#add_manual_time_for_step1_student_dropdown');
        const isOpen = $dd.is(':visible');
        if (forceOpen === true || !isOpen) {
          add_manual_time_for_step1_closeDropdowns();
          $dd.show();
          $('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'true');
          $('#add_manual_time_for_step1_student_search').val('').trigger('input').focus();
        } else {
          $dd.hide();
          $('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        }
      }
      $('#add_manual_time_for_step1_student_fake').on('click', function() {
        add_manual_time_for_step1_toggleStudentDropdown();
      });
      $('#add_manual_time_for_step1_student_fake').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          add_manual_time_for_step1_toggleStudentDropdown(true);
        }
      });
      $(document).on('click', '#add_manual_time_for_step1_student_list .add_manual_time_for_step1_dropdown_item', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        add_manual_time_for_step1_student_value = id;
        $('#add_manual_time_for_step1_student_fake_label').text(name);
        $('#add_manual_time_for_step1_student_dropdown').hide();
        $('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
      });

      /* ===== Group dropdown ===== */
      function add_manual_time_for_step1_renderGroupList(list) {
        const $list = $('#add_manual_time_for_step1_group_list');
        $list.empty();
        list.forEach(g => {
          const $row = $(`<div class="add_manual_time_for_step1_dropdown_item" data-id="${g.id}"><div class="add_manual_time_for_step1_name">${g.id}</div></div>`);
          $list.append($row);
        });
      }
      add_manual_time_for_step1_renderGroupList(add_manual_time_for_step1_groups);

      $('#add_manual_time_for_step1_group_search').on('input', function() {
        const q = $(this).val().toLowerCase();
        const filtered = add_manual_time_for_step1_groups.filter(g => g.id.toLowerCase().includes(q));
        add_manual_time_for_step1_renderGroupList(filtered);
      });

      function add_manual_time_for_step1_toggleGroupDropdown(forceOpen) {
        const $dd = $('#add_manual_time_for_step1_group_dropdown');
        const isOpen = $dd.is(':visible');
        if (forceOpen === true || !isOpen) {
          add_manual_time_for_step1_closeDropdowns();
          $dd.show();
          $('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'true');
          $('#add_manual_time_for_step1_group_search').val('').trigger('input').focus();
        } else {
          $dd.hide();
          $('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
        }
      }
      $('#add_manual_time_for_step1_group_fake').on('click', function() {
        add_manual_time_for_step1_toggleGroupDropdown();
      });
      $('#add_manual_time_for_step1_group_fake').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          add_manual_time_for_step1_toggleGroupDropdown(true);
        }
      });
      $(document).on('click', '#add_manual_time_for_step1_group_list .add_manual_time_for_step1_dropdown_item', function() {
        const id = $(this).data('id');
        add_manual_time_for_step1_group_value = id;
        $('#add_manual_time_for_step1_group_fake_label').text(id);
        $('#add_manual_time_for_step1_group_dropdown').hide();
        $('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
      });

      /* Close dropdowns on outside click */
      $('#add_manual_time_for_step1_modal').on('mousedown', function(e) {
        const $sWrap = $('#add_manual_time_for_step1_student_wrap');
        const $pWrap = $('#add_manual_time_for_step1_payable_fake').parent();
        const $gWrap = $('#add_manual_time_for_step1_group_wrap');
        if (!$.contains($sWrap[0], e.target)) {
          $('#add_manual_time_for_step1_student_dropdown').hide();
          $('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        }
        if (!$.contains($pWrap[0], e.target)) {
          $('#add_manual_time_for_step1_payable_dropdown').hide();
        }
        if (!$.contains($gWrap[0], e.target)) {
          $('#add_manual_time_for_step1_group_dropdown').hide();
          $('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
        }
      });

      /* Payable dropdown */
      $('#add_manual_time_for_step1_payable_fake').on('click', function() {
        const $dd = $('#add_manual_time_for_step1_payable_dropdown');
        if ($dd.is(':visible')) $dd.hide();
        else {
          add_manual_time_for_step1_closeDropdowns();
          $dd.show();
        }
      });
      $('#add_manual_time_for_step1_payable_list .add_manual_time_for_step1_dropdown_item').on('click', function() {
        $('#add_manual_time_for_step1_payable_label').text($(this).data('value'));
        $('#add_manual_time_for_step1_payable_dropdown').hide();
      });

    })(jQuery);
