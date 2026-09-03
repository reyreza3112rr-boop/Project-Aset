<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gerbang — Buat akun baru</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg-deep:#0F1712;
    --bg-panel:#16211A;
    --bg-card:#1B2620;
    --border:#2A3A2E;
    --border-soft:#233128;
    --brass:#C9A227;
    --brass-bright:#E4BE4A;
    --text-warm:#EDEAE0;
    --text-muted:#8FA08F;
    --text-dim:#5F7266;
    --teal:#4FA88A;
    --error:#D8735A;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{
    font-family:'Inter', sans-serif;
    background:var(--bg-deep);
    color:var(--text-warm);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:32px 16px;
  }
  .wrap{
    display:grid;
    grid-template-columns:1fr 1fr;
    max-width:960px;
    width:100%;
    min-height:660px;
    background:var(--bg-panel);
    border:1px solid var(--border);
    border-radius:20px;
    overflow:hidden;
  }
  .side{
    background:
      radial-gradient(circle at 30% 20%, rgba(201,162,39,0.07), transparent 55%),
      var(--bg-deep);
    padding:52px 44px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    position:relative;
    border-right:1px solid var(--border);
  }
  .brand{ display:flex; align-items:center; gap:10px; }
  .brand-mark{width:26px; height:26px; flex-shrink:0;}
  .brand-name{ font-family:'Fraunces', serif; font-size:20px; font-weight:500; letter-spacing:0.02em; }
  .keyhole-art{ align-self:center; margin:auto 0; }
  .side-copy{ font-family:'Fraunces', serif; font-size:26px; line-height:1.35; font-weight:400; color:var(--text-warm); max-width:320px; }
  .side-sub{ font-size:14px; color:var(--text-muted); margin-top:14px; line-height:1.6; max-width:300px; }
  .side-foot{ font-size:12px; color:var(--text-dim); font-family:'JetBrains Mono', monospace; letter-spacing:0.03em; }
  .form-side{ background:var(--bg-panel); padding:44px 48px; display:flex; flex-direction:column; justify-content:center; overflow-y:auto; }
  .form-head h1{ font-family:'Fraunces', serif; font-size:26px; font-weight:500; margin-bottom:6px; }
  .form-head p{ font-size:14px; color:var(--text-muted); margin-bottom:22px; }
  .session-error{
    background:rgba(216,115,90,0.1);
    border:1px solid var(--error);
    color:var(--error);
    font-size:13px;
    padding:10px 14px;
    border-radius:10px;
    margin-bottom:20px;
  }
  .social-row{ display:flex; flex-direction:column; gap:10px; margin-bottom:22px; }
  .social-btn{
    display:flex; align-items:center; justify-content:center; gap:10px;
    width:100%; padding:11px 16px; background:var(--bg-card);
    border:1px solid var(--border); border-radius:10px; color:var(--text-warm);
    font-size:14px; font-weight:500; cursor:pointer;
    transition:border-color 0.15s ease, background 0.15s ease;
    text-decoration:none;
  }
  .social-btn:hover{ border-color:var(--border-soft); background:#20302566; }
  .social-btn svg{ width:18px; height:18px; flex-shrink:0; }
  .divider{
    display:flex; align-items:center; gap:14px; margin:6px 0 20px;
    color:var(--text-dim); font-size:12px; font-family:'JetBrains Mono', monospace;
    text-transform:uppercase; letter-spacing:0.08em;
  }
  .divider::before, .divider::after{ content:""; flex:1; height:1px; background:var(--border); }
  .field{ margin-bottom:14px; }
  .field label{ display:block; font-size:12px; color:var(--text-muted); margin-bottom:6px; font-weight:500; }
  .field-input-wrap{ position:relative; }
  .field input{
    width:100%; padding:11px 14px; background:var(--bg-card);
    border:1px solid var(--border); border-radius:10px; color:var(--text-warm);
    font-size:14px; font-family:'Inter', sans-serif; outline:none;
    transition:border-color 0.15s ease;
  }
  .field input.has-error{ border-color:var(--error); }
  .field input:focus{ border-color:var(--brass); }
  .field input::placeholder{ color:var(--text-dim); }
  .toggle-pw{
    position:absolute; right:12px; top:50%; transform:translateY(-50%);
    background:none; border:none; color:var(--text-dim); cursor:pointer;
    font-size:12px; font-family:'JetBrains Mono', monospace; letter-spacing:0.03em;
  }
  .toggle-pw:hover{ color:var(--text-muted); }
  .captcha{ margin:18px 0; }
  .captcha-label{ font-size:12px; color:var(--text-muted); margin-bottom:8px; font-weight:500; }
  .slider-track{
    position:relative; height:46px; background:var(--bg-card);
    border:1px solid var(--border); border-radius:10px; overflow:hidden; user-select:none;
  }
  .slider-fill{ position:absolute; top:0; left:0; bottom:0; width:0%; background:linear-gradient(90deg, rgba(79,168,138,0.18), rgba(79,168,138,0.32)); transition:width 0.05s linear; }
  .slider-text{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:13px; color:var(--text-dim); letter-spacing:0.02em; pointer-events:none; }
  .slider-thumb{
    position:absolute; top:2px; left:2px; width:42px; height:42px; border-radius:8px;
    background:var(--bg-panel); border:1px solid var(--brass); display:flex; align-items:center; justify-content:center;
    cursor:grab; transition:left 0.05s linear, background 0.2s ease, border-color 0.2s ease;
  }
  .slider-thumb:active{ cursor:grabbing; }
  .slider-thumb svg{ width:18px; height:18px; stroke:var(--brass); transition:stroke 0.2s ease, transform 0.3s ease; }
  .slider-track.verified{ border-color:var(--teal); }
  .slider-track.verified .slider-fill{ width:100% !important; background:rgba(79,168,138,0.28); }
  .slider-track.verified .slider-thumb{ border-color:var(--teal); background:var(--bg-panel); }
  .slider-track.verified .slider-thumb svg{ stroke:var(--teal); transform:rotate(90deg); }
  .slider-track.verified .slider-text{ color:var(--teal); }
  .submit-btn{
    width:100%; padding:13px; background:var(--brass); border:none; border-radius:10px;
    color:#1A1408; font-size:14px; font-weight:600; cursor:pointer;
    transition:background 0.15s ease, opacity 0.15s ease; font-family:'Inter', sans-serif;
  }
  .submit-btn:hover{ background:var(--brass-bright); }
  .error-msg{ font-size:12px; color:var(--error); margin-top:6px; min-height:16px; }
  .signup-line{ text-align:center; font-size:13px; color:var(--text-muted); margin-top:20px; }
  .signup-line a{ color:var(--brass); text-decoration:none; }
  .signup-line a:hover{ color:var(--brass-bright); }
  @media (max-width:760px){
    .wrap{ grid-template-columns:1fr; }
    .side{ display:none; }
    .form-side{ padding:40px 26px; }
  }
</style>
</head>
<body>

<div class="wrap">

  <div class="side">
    <div class="brand">
      <svg class="brand-mark" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="1.6">
        <circle cx="12" cy="9" r="4.5"/>
        <path d="M12 13.2V20M9 17h6"/>
      </svg>
      <span class="brand-name">Gerbang</span>
    </div>

    <svg class="keyhole-art" width="160" height="160" viewBox="0 0 160 160" fill="none">
      <circle cx="80" cy="80" r="72" stroke="#233128" stroke-width="1"/>
      <circle cx="80" cy="80" r="56" stroke="#233128" stroke-width="1"/>
      <g>
        <circle cx="80" cy="64" r="20" stroke="#C9A227" stroke-width="1.6"/>
        <path d="M80 84 L80 116 M67 100 L93 100" stroke="#C9A227" stroke-width="1.6" stroke-linecap="round"/>
      </g>
    </svg>

    <div>
      <p class="side-copy">Bergabung, mulai kelola ruang kerja Anda.</p>
      <p class="side-sub">Buat akun baru dengan email, atau daftar sekejap pakai akun yang sudah Anda percaya.</p>
    </div>

    <p class="side-foot">akses-terenkripsi · 256-bit</p>
  </div>

  <div class="form-side">
    <div class="form-head">
      <h1>Buat akun baru</h1>
      <p>Isi data di bawah untuk mulai</p>
    </div>

    @if ($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password') && !$errors->has('captcha_verified'))
      <div class="session-error">Terjadi kesalahan. Periksa kembali data Anda.</div>
    @endif

    <div class="social-row">
      <a href="{{ route('auth.redirect', 'google') }}" class="social-btn">
        <svg viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.9-2.26 5.36-4.78 7.02l7.73 6c4.51-4.18 7.09-10.36 7.09-17.49z"/><path fill="#FBBC05" d="M10.53 28.59a14.5 14.5 0 0 1 0-9.18l-7.98-6.19a24 24 0 0 0 0 21.56l7.98-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.9l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        Lanjutkan dengan Google
      </a>
      <a href="{{ route('auth.redirect', 'github') }}" class="social-btn">
        <svg viewBox="0 0 24 24" fill="#EDEAE0"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.57.1.78-.25.78-.55v-2.15c-3.2.7-3.87-1.36-3.87-1.36-.53-1.33-1.28-1.69-1.28-1.69-1.05-.71.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.25.73-1.54-2.56-.29-5.25-1.28-5.25-5.7 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.18-1.18 3.18-1.18.63 1.59.23 2.77.11 3.06.74.8 1.19 1.83 1.19 3.09 0 4.43-2.69 5.4-5.26 5.69.42.36.78 1.07.78 2.15v3.19c0 .31.21.66.79.55C20.71 21.38 24 17.07 24 12 24 5.65 18.35.5 12 .5Z"/></svg>
        Lanjutkan dengan GitHub
      </a>
    </div>

    <div class="divider">atau dengan email</div>

    <form method="POST" action="{{ route('register.submit') }}" id="register-form" novalidate>
      @csrf

      <div class="field">
        <label for="name">Nama lengkap</label>
        <input type="text" name="name" id="name" class="{{ $errors->has('name') ? 'has-error' : '' }}"
               value="{{ old('name') }}" placeholder="Nama Anda" autocomplete="name">
        @error('name')
          <div class="error-msg">{{ $message }}</div>
        @enderror
      </div>

      <div class="field">
        <label for="email">Alamat email</label>
        <input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'has-error' : '' }}"
               value="{{ old('email') }}" placeholder="nama@perusahaan.com" autocomplete="email">
        @error('email')
          <div class="error-msg">{{ $message }}</div>
        @enderror
      </div>

      <div class="field">
        <label for="password">Kata sandi</label>
        <div class="field-input-wrap">
          <input type="password" name="password" id="password" class="{{ $errors->has('password') ? 'has-error' : '' }}"
                 placeholder="Minimal 8 karakter" autocomplete="new-password">
          <button type="button" class="toggle-pw" data-target="password">lihat</button>
        </div>
        @error('password')
          <div class="error-msg">{{ $message }}</div>
        @enderror
      </div>

      <div class="field">
        <label for="password_confirmation">Konfirmasi kata sandi</label>
        <div class="field-input-wrap">
          <input type="password" name="password_confirmation" id="password_confirmation"
                 placeholder="Ulangi kata sandi" autocomplete="new-password">
          <button type="button" class="toggle-pw" data-target="password_confirmation">lihat</button>
        </div>
      </div>

      <div class="captcha">
        <div class="captcha-label">Verifikasi bahwa Anda manusia</div>
        <div class="slider-track" id="slider-track">
          <div class="slider-fill" id="slider-fill"></div>
          <div class="slider-text" id="slider-text">Geser kunci untuk membuka →</div>
          <div class="slider-thumb" id="slider-thumb">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="8" cy="8" r="4"/>
              <path d="M11 11l9 9M17 17l2-2M19.5 14.5l2-2"/>
            </svg>
          </div>
        </div>
        <input type="hidden" name="captcha_verified" id="captcha_verified" value="0">
        <div class="error-msg" id="captcha-client-error">
          @error('captcha_verified'){{ $message }}@enderror
        </div>
      </div>

      <button type="submit" class="submit-btn" id="submit-btn">Daftar</button>
    </form>

    <p class="signup-line">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
  </div>

</div>

<script>
  document.querySelectorAll('.toggle-pw').forEach(function(btn){
    btn.addEventListener('click', function(){
      const input = document.getElementById(btn.dataset.target);
      const isPw = input.type === 'password';
      input.type = isPw ? 'text' : 'password';
      btn.textContent = isPw ? 'sembunyikan' : 'lihat';
    });
  });

  const track = document.getElementById('slider-track');
  const thumb = document.getElementById('slider-thumb');
  const fill = document.getElementById('slider-fill');
  const sliderText = document.getElementById('slider-text');
  const captchaInput = document.getElementById('captcha_verified');
  const captchaClientError = document.getElementById('captcha-client-error');
  let verified = false;
  let dragging = false;
  let startX = 0;
  let thumbStartLeft = 0;

  function trackWidth(){ return track.clientWidth - thumb.clientWidth - 4; }

  function onDragStart(clientX){
    if(verified) return;
    dragging = true;
    startX = clientX;
    thumbStartLeft = parseFloat(thumb.style.left || 2);
  }

  function onDragMove(clientX){
    if(!dragging || verified) return;
    let delta = clientX - startX;
    let newLeft = Math.min(Math.max(thumbStartLeft + delta, 2), trackWidth());
    thumb.style.left = newLeft + 'px';
    let pct = (newLeft / trackWidth()) * 100;
    fill.style.width = pct + '%';
    if(newLeft >= trackWidth() - 1){
      verified = true;
      dragging = false;
      track.classList.add('verified');
      sliderText.textContent = 'Terverifikasi';
      captchaInput.value = '1';
      captchaClientError.textContent = '';
    }
  }

  function onDragEnd(){
    if(!dragging) return;
    dragging = false;
    if(!verified){
      thumb.style.left = '2px';
      fill.style.width = '0%';
    }
  }

  thumb.addEventListener('mousedown', e => onDragStart(e.clientX));
  window.addEventListener('mousemove', e => onDragMove(e.clientX));
  window.addEventListener('mouseup', onDragEnd);
  thumb.addEventListener('touchstart', e => onDragStart(e.touches[0].clientX), {passive:true});
  window.addEventListener('touchmove', e => { if(dragging) onDragMove(e.touches[0].clientX); }, {passive:true});
  window.addEventListener('touchend', onDragEnd);

  document.getElementById('register-form').addEventListener('submit', function(e){
    if(captchaInput.value !== '1'){
      e.preventDefault();
      captchaClientError.textContent = 'Selesaikan verifikasi dengan menggeser kunci ke ujung.';
    }
  });
</script>

</body>
</html>