@extends('layouts.frontend')

@section('homeContent')

  <!-- Top Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <div class="logo">
        <div class="logo-icon">
          <img src="{{ asset('build/assets/img/logo.png') }}" alt="AKTech logo" />
        </div>
      </div>
    </div>
    <div class="navbar-right">
      <a href="{{ route('view.home') }}" class="nav-link">Home</a>




      @if($user->role === 'teacher')
        <a class="nav-link" href="{{ route('teacher.panel') }}">
          {{-- <button class="teacher-btn"> --}}
            {{-- <span class="teacher-btn-icon">T</span> --}}
            Teacher Section
            {{-- </button> --}}
        </a>
      @endif
      @if($user->role === 'student')
        <a class="nav-link" href="{{ route('student.panel') }}">
          {{-- <span class="teacher-btn-icon">T</span> --}}
          Student Section
        </a>
      @endif
      <a href="{{ route('home.logout') }}" class="nav-link">
        Logout
      </a>
      <span class="teacher-btn" style="cursor: auto !important;">

        <!--<span class="teacher-btn-icon">T</span>-->
        {{ $user->name }}

      </span>


    </div>
  </div>

  <!-- Page Content -->
  <div class="page">
    <!-- Filters row -->
    <div class="filters-row">
      <div class="select">
        <select id="board_id">
          <option value="">Select Board</option>
          @foreach($boards as $board)
            <option value="{{ $board->id }}">{{ $board->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="select">

        <select id="subject_id">
          <option value="">Select Subject</option>
        </select>
      </div>
      <div class="select">
        <select id="class_id">
          <option value="">Select Class</option>
        </select>
      </div>
      <div class="select">

        <select id="book_id">
          <option value="">Select Book</option>
        </select>
      </div>

      <button id="searchBtn" class="search-button">Search</button>

      {{-- <div class="search-bar">
        <span>Search:</span>
        <input type="text" placeholder="Search e-books..." />
      </div> --}}
    </div>

    <!-- Content area (phone + book) -->
    <div class="content">
      <!-- Phone mockup -->
      <div class="phone-wrapper">
        <div class="phone">
          <div class="phone-screen">
            <div class="phone-header">
              <span>09:30</span>
              <span>LTE ▰▰▰</span>
            </div>
            <div class="phone-apps" id="contentList">
              <div class="text-muted">Select a book and click Search</div>
            </div>
          </div>
          <div class="phone-dock">
            <div class="phone-dock-icon">
              <i class="fa-solid fa-book"></i>
            </div>
            <div class="phone-dock-icon">
              <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="phone-dock-icon">
              <i class="fa-solid fa-chalkboard"></i>
            </div>
            <div class="phone-dock-icon">
              <i class="fa-solid fa-certificate"></i>
            </div>
          </div>
          <div class="phone-home-indicator"></div>
        </div>
      </div>

      <!-- Book card -->
      <div class="books-area">
        <!--<div class="show-entries">-->
        <!--  Show-->
        <!--  <select>-->
        <!--    <option>10</option>-->
        <!--    <option>25</option>-->
        <!--  </select>-->
        <!--  entries-->
        <!--</div>-->

        <div class="books-grid" id="bookFiles">
          <div class="text-muted">Select content to view files</div>
        </div>


        <div class="pagination-row">
          <div>Showing 1 to 1 of 1 entries</div>
          <div class="pagination-buttons">
            <button class="page-btn">Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-logo">
        <div class="footer-logo-icon">
          <img src="{{ asset('build/assets/img/logo.png') }}" alt="AKTech logo" />
        </div>
        <div class="footer-logo-text">
          <span class="footer-ak">AK</span><span class="footer-tech">Tech Solutions</span>
        </div>
      </div>
      <div class="footer-info">
        <p>&copy; {{ date('Y') }} AK Tech Solutions. All rights reserved.</p>
        <p>Empowering Education Through Technology</p>
      </div>
      {{-- <div class="footer-links">
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
      </div> --}}
    </div>
  </footer>

  <!-- Page loader (shown when search is clicked) -->
  <div id="page-loader" class="loader-overlay" aria-hidden="true">
    <!-- Use GIF from loader folder; fallback to logo if missing -->
    <img id="loader-image" class="loader-image" src="{{ asset('build/assets/loader/Loadingcircles.gif') }}"
      alt="Loading" />
  </div>

@endsection

@push('scripts')

  <script>

    $(document).ready(function () {



      // Board → Subjects
      $('#board_id').on('change', function () {
        let boardId = $(this).val();

        $('#subject_id').html('<option>Loading...</option>');
        $('#class_id').html('<option value="">Select Class</option>');
        $('#book_id').html('<option value="">Select Book</option>');

        if (boardId) {
          $.get('/get-subjects/' + boardId, function (data) {
            let options = '<option value="">Select Subject</option>';
            $.each(data, function (i, subject) {
              options += `<option value="${subject.id}">${subject.subject_name}</option>`;
            });
            $('#subject_id').html(options);
          });
        }
      });

      // Subject → Classes
      $('#subject_id').on('change', function () {
        let subjectId = $(this).val();

        $('#class_id').html('<option>Loading...</option>');
        $('#book_id').html('<option value="">Select Book</option>');

        if (subjectId) {
          $.get('/get-classes/' + subjectId, function (data) {
            let options = '<option value="">Select Class</option>';
            $.each(data, function (i, cls) {
              options += `<option value="${cls.id}">${cls.class_name}</option>`;
            });
            $('#class_id').html(options);
          });
        }
      });

      // Subject + Class → Books
      $('#class_id').on('change', function () {
        let subjectId = $('#subject_id').val();
        let classId = $(this).val();

        $('#book_id').html('<option>Loading...</option>');

        if (subjectId && classId) {
          $.get('/get-books', {
            subject_id: subjectId,
            class_id: classId
          }, function (data) {
            let options = '<option value="">Select Book</option>';
            $.each(data, function (i, book) {
              options += `<option value="${book.id}">${book.book_name}</option>`;
            });
            $('#book_id').html(options);
          });
        }
      });

      function getContentIcon(type) {
        switch (type) {
          case 'E-book':
            return 'fa-solid fa-book-open';
          case 'Supplement':
            return 'fa-solid fa-clipboard-list';
          case 'Lesson Plan':
            return 'fa-solid fa-chalkboard-user';
          case 'Answer Key':
            return 'fa-solid fa-key';
          case 'Test Paper Generator':
            return 'fa-solid fa-file-pen';
          default:
            return 'fa-solid fa-folder';
        }
      }

    //   function getContentIconHTML(type) {
    //     if (type === 'E-book') {
    //       return '<img src="{{ asset("build/assets/img/ebook.gif") }}" alt="E-book" style="width: 100%; height: 100%; object-fit: contain;" />';
    //     }
    //     return `<i class="${getContentIcon(type)}"></i>`;
    //   }
      
      function getContentIconHTML(type) {
        if (type === 'E-book') {
          return '<img src="{{ asset("build/assets/img/ebook.gif") }}" alt="E-book" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
        if (type === 'Test Paper Generator') {
          return '<img src="{{ asset("build/assets/img/test.gif") }}" alt="TPG" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
        if (type === 'Answer Key') {
          return '<img src="{{ asset("build/assets/img/q-and-a.gif") }}" alt="Answer Key" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
        if (type === 'Practice Worksheet') {
          return '<img src="{{ asset("build/assets/img/agreement.gif") }}" alt="Answer Key" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
        if (type === 'Lesson Plan') {
          return '<img src="{{ asset("build/assets/img/classroom-lesson.gif") }}" alt="Answer Key" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
        if (type === 'Topic Animation') {
          return '<img src="{{ asset("build/assets/img/video-player.gif") }}" alt="Answer Key" style="width: 100%; height: 100%; object-fit: contain;" />';
        }
     
        return `<i class="${getContentIcon(type)}"></i>`;
      }

      function showLoader() {
        $('#page-loader').css('display', 'flex').attr('aria-hidden', 'false');
      }

      function hideLoader() {
        $('#page-loader').css('display', 'none').attr('aria-hidden', 'true');
      }

      function renderContents(contents, bookId) {

        let requests = [];
        let results = [];

        $('#contentList').html('<div class="text-muted">Loading contents...</div>');

        $.each(contents, function (index, content) {

          let request = $.ajax({
            url: '/get-book-files-for-content',
            type: 'GET',
            data: {
              book_id: bookId,
              content_id: content.id
            }
          }).done(function (files) {

            // Skip if no files
            if (!files || files.length === 0) {
              return;
            }

            results.push(`
                                                                      <div class="phone-app content-item"
                                                                           data-book-id="${bookId}"
                                                                           data-content-id="${content.id}">
                                                                          <div class="phone-app-icon">
                                                                              ${getContentIconHTML(content.content_name)}
                                                                          </div>
                                                                          <div>${content.content_name}</div>
                                                                      </div>
                                                                  `);
          });

          requests.push(request);
        });

        $.when.apply($, requests).done(function () {

          if (results.length === 0) {
            $('#contentList').html(
              '<div class="text-muted">No usable content available</div>'
            );
          } else {
            $('#contentList').html(results.join(''));
          }
        });
      }



      $('#searchBtn').on('click', function () {

        let bookId = $('#book_id').val();

        if (!bookId) {
          alert('Please select a book');
          return;
        }

        showLoader();

        $('#contentList').html('');
        $('#bookFiles').html('');

        $.ajax({
          url: '/get-book-contents/' + bookId,
          type: 'GET'
        })
          .done(function (contents) {

            if (!contents || contents.length === 0) {
              $('#contentList').html('<div>No contents found</div>');
              return;
            }

            renderContents(contents, bookId);
          })
          .always(function () {
            hideLoader();
          });
      });


      $(document).on('click', '.book-card', function (e) {
        if ($(e.target).closest('a').length) return; // ignore buttons

        let url = $(this).data('view-url');
        if (url) window.open(url, '_blank');
      });


      // Getting book content files

      let currentBookId = null;
      let currentContentId = null;

      $('.pagination-row').hide();

      function renderPagination(res) {

        let html = '';

        if (res.current_page > 1) {
          html += `<button class="page-btn" data-page="${res.current_page - 1}">Previous</button>`;
        }

        for (let i = 1; i <= res.last_page; i++) {
          html += `
                                                                  <button class="page-btn ${i === res.current_page ? 'active' : ''}"
                                                                          data-page="${i}">
                                                                      ${i}
                                                                  </button>
                                                              `;
        }

        if (res.current_page < res.last_page) {
          html += `<button class="page-btn" data-page="${res.current_page + 1}">Next</button>`;
        }

        $('.pagination-buttons').html(html);
        $('.pagination-row').show();

        $('.pagination-row div:first').text(
          `Showing ${res.from} to ${res.to} of ${res.total} entries`
        );
      }

      function loadBookFiles(page = 1) {

        $('#bookFiles').html('Loading files...');

        showLoader();

        $.ajax({
          url: '/get-book-files',
          type: 'GET',
          data: {
            book_id: currentBookId,
            content_id: currentContentId,
            page: page
          }
        })
          .done(function (res) {

            hideLoader();

            if (!res.data || res.data.length === 0) {
              $('#bookFiles').html('<p>No files available</p>');
              $('.pagination-row').hide();
              return;
            }

            let html = '';

            $.each(res.data, function (i, file) {

              let viewUrl = '';
              let showDownload = false;

              if (file.content_type === 'e-book' || file.content_type === 'test paper generator') {
                viewUrl = `/storage/${file.extract_path}/${file.entry_file}`;
                showDownload = true;
              } else {
                viewUrl = `/storage/${file.file_path}`;
              }

              html += `
                                                                      <div class="book-card" data-view-url="${viewUrl}" style="animation-delay: ${i * 0.15}s;">
                                                                          <div class="book-banner">Click to View</div>
                                                                          <div class="book-cover">
                                                                              <img src="/storage/${file.thumbnail}">
                                                                          </div>
                                                                          <div class="book-footer">
                                                                              <div class="book-title-text">${file.title}</div>
                                                                              ${showDownload ? `
                                                                                  <a href="/storage/${file.file_path}" class="download-btn" download>
                                                                                      Download ZIP
                                                                                  </a>
                                                                              ` : ''}
                                                                          </div>
                                                                      </div>
                                                                  `;
            });

            $('#bookFiles').html(html);
            renderPagination(res);
          });
      }

      $(document).on('click', '.page-btn', function () {
        let page = $(this).data('page');
        loadBookFiles(page);
      });

      $(document).on('click', '.content-item', function () {
        currentBookId = $(this).data('book-id');
        currentContentId = $(this).data('content-id');

        loadBookFiles(1); // always start from page 1

      });


    });
  </script>

@endpush