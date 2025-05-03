<?php 
session_start(); // Start the session
$error = ""; // Initialize the variable
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}

// Include the database configuration file
include('../database/config.php'); // Adjust the path as necessary

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, account FROM users_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $account);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session and redirect based on account type
            $_SESSION['username'] = $username;
            $_SESSION['account'] = $account; // Store account type in session

            // Redirect based on account type
            if ($account === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else if ($account === 'staff') {
                header("Location: ../staff/dashboard.php");
            } else {
                header("Location: login.php?error=Invalid account type");
            }
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=Invalid password");
            exit();
        }
    } else {
        // No user found
        header("Location: login.php?error=No user found");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>WeHealth Sign In</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Inter', sans-serif;
    }
   /* Slanting blue shape on right side */
   .slant-bg {
     position: absolute;
     top: 0;
     right: 0;
     width: 55%;
     height: 100%;
     background: linear-gradient(to bottom, #3ddbd9, #1a3ea8);
     clip-path: polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%);
     z-index: 0;
   }
   /* Additional subtle diagonal stripes on white area */
   .diagonal-stripes {
     position: absolute;
     top: 0;
     left: 0;
     width: 45%;
     height: 100%;
     background-image: repeating-linear-gradient(
         45deg,
         rgba(255,255,255,0.1),
         rgba(255,255,255,0.1) 10px,
         transparent 10px,
         transparent 20px
       );
     pointer-events: none;
     z-index: 1;
   }
   /* Soft glowing circles on blue side */
   .glow-circle {
     position: absolute;
     border-radius: 50%;
     filter: blur(60px);
     opacity: 0.3;
     z-index: 0;
   }
   .glow1 {
     width: 220px;
     height: 220px;
     background: #f9b233;
     top: 18%;
     right: 30%;
   }
   .glow2 {
     width: 140px;
     height: 140px;
     background: #3ddbd9;
     bottom: 12%;
     right: 15%;
   }
   /* Subtle vertical lines on white side */
   .vertical-lines {
     position: absolute;
     top: 0;
     left: 0;
     width: 45%;
     height: 100%;
     background-image: repeating-linear-gradient(
         to bottom,
         rgba(0,0,0,0.02),
         rgba(0, 0,0,0,0.02) 1px,
         transparent 1px,
         transparent 20px
       );
     pointer-events: none;
     z-index: 1;
   }
   /* Large faint "WeHealth" text behind form */
   .background-text {
     position: absolute;
     top: 50%;
     left: 8%;
     transform: translateY(-50%);
     font-size: 7rem;
     font-weight: 900;
     color: rgba(29, 78, 216, 0.05);
     user-select: none;
     pointer-events: none;
     z-index: 0;
     white-space: nowrap;
   }
   /* Small tagline below logo */
   .tagline {
     font-size: 0.75rem;
     color: #3ddbd9;
     font-weight: 600;
     user-select: none;
   }
   /* Bottom left corner small info box */
   .info-box {
     position: absolute;
     bottom: 12px;
     left: 12px;
     background: #3ddbd9;
     color: white;
     padding: 6px 14px;
     border-radius: 12px;
     font-size: 0.75rem;
     font-weight: 600;
     box-shadow: 0 0 8px #3ddbd9aa;
     user-select: none;
     z-index: 10;
     max-width: 280px;
   }
   /* Top left small icon cluster */
   .icon-cluster {
     position: absolute;
     top: 20px;
     left: 20px;
     display: flex;
     gap: 14px;
     z-index: 10;
   }
   .icon-circle {
     background: #f9b233;
     width: 40px;
     height: 40px;
     border-radius: 50%;
     display: flex;
     align-items: center;
     justify-content: center;
     color: #1a3ea8;
     font-size: 20px;
     box-shadow: 0 0 8px #f9b233aa;
     cursor: default;
   }
   /* Quote box on right side bottom - smaller and lower */
   .quote-box {
     position: absolute;
     bottom: 20px;
     right: 50px;
     max-width: 280px;
     background: rgba(255 255 255 / 0.9);
     border-radius: 20px;
     padding: 14px 18px;
     box-shadow: 0 6px 16px rgb(0 0 0 / 0.12);
     font-style: italic;
     color: #1a3ea8;
     font-weight: 600;
     font-size: 0.85rem;
     user-select: none;
     z-index: 10;
     line-height: 1.4;
   }
   /* Additional decorative small circles on blue side */
   .decorative-circle {
     position: absolute;
     border-radius: 50%;
     background: rgba(255 255 255 / 0.15);
     box-shadow: 0 0 10px rgba(255 255 255 / 0.2);
     z-index: 0;
   }
   .decor1 {
     width: 60px;
     height: 60px;
     top: 15%;
     right: 12%;
   }
   .decor2 {
     width: 90px;
     height: 90px;
     top: 40%;
     right: 5%;
   }
   .decor3 {
     width: 40px;
     height: 40px;
     bottom: 30%;
     right: 20%;
   }
   /* Additional floating medical icons on right side */
   .floating-icon {
     position: absolute;
     background: white;
     border-radius: 50%;
     width: 48px;
     height: 48px;
     box-shadow: 0 4px 12px rgb(0 0 0 / 0.15);
     display: flex;
     align-items: center;
     justify-content: center;
     color: #1a3ea8;
     font-size: 22px;
     z-index: 15;
     transition: transform 0.3s ease;
   }
   .floating-icon:hover {
     transform: scale(1.15);
     box-shadow: 0 6px 18px rgb(0 0 0 / 0.25);
     cursor: pointer;
   }
   .icon1 {
     top: 20%;
     right: 35%;
   }
   .icon2 {
     top: 45%;
     right: 28%;
   }
   .icon3 {
     bottom: 40%;
     right : 35%;
   }
   .icon4 {
     bottom: 20%;
     right: 28%;
   }
   /* Language dropdown */
   .language-dropdown {
     position: absolute;
     top: 6px;
     right: 6px;
     z-index: 20;
   }
   /* Image Not Included label */
   .image-label {
     position: absolute;
     bottom: 6px;
     right: 6px;
     background: white;
     text-align: center;
     font-size: 0.75rem;
     font-weight: 600;
     color: #1a3ea8;
     padding: 6px 12px;
     border-radius: 12px;
     box-shadow: 0 0 4px rgb(26 62 168 / 0.5);
     user-select: none;
     z-index: 20;
   }
   /* Responsive adjustments */
   @media (max-width: 1024px) {
     .slant-bg {
       width: 50%;
       clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%);
     }
     .diagonal-stripes, .vertical-lines {
       width: 50%;
     }
     .background-text {
       font-size: 5rem;
       left: 6%;
     }
     .quote-box {
       max-width: 260px;
       bottom: 20px;
       right: 30px;
       padding: 12px 16px;
       font-size: 0.8rem;
     }
     .icon-circle {
       width: 36px;
       height: 36px;
       font-size: 18px;
     }
     .floating-icon {
       width: 40px;
       height: 40px;
       font-size: 18px;
     }
   }
   @media (max-width: 768px) {
     .background-text {
       font-size: 3rem;
       left: 5%;
     }
     .quote-box {
       position: static;
       max-width: 100%;
       margin-top: 20px;
       background: #f9b233;
       color: #1a3ea8;
       font-style: normal;
       box-shadow: none;
       border-radius: 12px;
       padding: 12px 16px;
       font-size: 0.9rem;
     }
     .icon-cluster {
       top: auto;
       left: auto;
       bottom: 12px;
       right: 12px;
     }
     .slant-bg {
       display: none;
     }
     .diagonal-stripes, .vertical-lines {
       display: none;
     }
     .decorative-circle {
       display: none;
     }
     .floating-icon {
       display: none;
     }
   }
  </style>
 </head>
 <body class="min-h-screen bg-gradient-to-b from-[#3ddbd9] to-[#1a3ea8] flex items-center justify-center p-4">
  <div class="relative w-full max-w-[1100px] h-[520px] rounded-lg shadow-lg flex overflow-hidden bg-white">
   <div class="slant-bg"></div>
   <div class="diagonal-stripes"></div>
   <div class="vertical-lines"></div>
   <div class="glow-circle glow1"></div>
   <div class="glow-circle glow2"></div>
   <div class="decorative-circle decor1"></div>
   <div class="decorative-circle decor2"></div>
   <div class="decorative-circle decor3"></div>
   <div class="background-text select-none">WeHealth</div>
   <div class="relative z-10 flex flex-col justify-center px-14 py-12 w-1/2">
    <div class="mb-1 flex flex-col">
     <div class="flex items-center space-x-2">
      <div class="w-10 h-10 flex flex-wrap gap-[2px]">
       <div class="w-4 h-4 rounded-sm bg-[#3ddbd9]"></div>
       <div class="w-4 h-4 rounded-sm bg-[#f9b233]"></div>
       <div class="w-4 h-4 rounded-sm bg-[#3ddbd9]"></div>
       <div class="w-4 h-4 rounded-sm bg-[#f9b233]"></div>
      </div>
      <span class="text-[#1a3ea8] font-semibold text-lg select-none">WeHealth</span>
     </div>
     <div class="tagline mt-1 select-none">Your Health, Our Priority</div>
    </div>
    <div class="bg-gradient-to-b from [#3ddbd9] to-[#1a3ea8] p-8 rounded-lg shadow-lg max-w-[360px] w-full relative z-20">
     <h2 class="text-white font-semibold text-xl mb-6">Sign In</h2>
     <?php if ($error): ?>
         <div class="bg-red-500 text-white p-2 rounded mb-4 text-center"><?php echo $error; ?></div>
     <?php endif; ?>
     <form method="POST" action="login.php" class="space-y-4">
         <input class="w-full rounded-md px-3 py-2 text-sm placeholder-[#cbd5e1] focus:outline-none" placeholder="Account Name" type="text" id="username" name="username" required/>
         <div class="relative">
             <input class="w-full rounded-md px-3 py-2 pr-10 text-sm placeholder-[#cbd5e1] focus:outline-none" placeholder="Password" type="password" id="password" name="password" required/>
             <button aria-label="Toggle password visibility" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#cbd5e1] text-sm focus:outline-none" type="button">
                 <i class="fas fa-eye-slash"></i>
             </button>
         </div>
         <div class="flex items-center justify-between text-xs text-white select-none">
             <label class="flex items-center space-x-1">
                 <input class="w-3 h-3 rounded border border-white bg-white checked:bg-[#3ddbd9]" type="checkbox" name="remember_me"/>
                 <span>Remember me</span>
             </label>
             <a class="text-[#f9b233] hover:underline" href="#">Forgot Password?</a>
         </div>
         <button class="mt-4 w-full bg-white text-[#1a3ea8] font-semibold rounded-full py-2 text-sm hover:bg-[#e6e6e6] transition" type="submit">Log In</button>
     </form>
    </div>
   </div>
   <div class="relative z-10 w-1/2 flex items-center justify-center overflow-visible">
     <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[360px] rounded-[40px] bg-gradient-to-b from-[#f9b233] to-[#f9b233] flex items-center justify-center overflow-visible" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
         <img alt="Smiling female doctor wearing white coat and holding stethoscope" class="w-full h-full object-cover rounded-[40px]" draggable="false" height="360" src="https://storage.googleapis.com/a1aa/image/7f6e345b-5a65-4ed8-c745-4c0ccb25a93a.jpg" width="320"/>
     </div>
     <div class="absolute bottom-28 left-12 bg-white rounded-lg shadow-md flex items-center space-x-3 px-5 py-3 max-w-[240px]">
         <div class="text-[#1a3ea8] text-lg">
             <i class="fas fa-video"></i>
         </div>
         <div>
             <p class="text-[#1a3ea8] font-semibold text-sm">Connect with a Doctor and Nurse</p>
         </div>
     </div>
     <div class="absolute top-28 right-12 bg-white rounded-lg shadow-md flex items-center space-x-3 px-5 py-2 max-w-[180px]">
         <div class="text-xs font-semibold text-gray-700 select-none">7k+ Students</div>
         <div class="flex -space-x-2">
             <img alt="Avatar of customer A" class="w-7 h-7 rounded-full border-2 border-white" draggable="false" height="28" src="https://storage.googleapis.com/a1aa/image/9cb08b8f-6eb0-47ff-934b-04d338a589c9.jpg" width="28"/>
             <img alt="Avatar of customer B" class="w-7 h-7 rounded-full border-2 border-white" draggable="false" height="28" src="https://storage.googleapis.com/a1aa/image/06e61887-452b-4f78-9ff2-314de99083b8.jpg" width="28"/>
             <img alt="Avatar of customer C" class="w-7 h-7 rounded-full border-2 border-white" draggable="false" height="28" src="https://storage.googleapis.com/a1aa/image/c9850902-a291-4f51-d62d-5e659e39178a.jpg" width="28"/>
             <img alt="Avatar of customer D" class="w-7 h-7 rounded-full border-2 border-white" draggable="false" height="28" src="https://storage.googleapis.com/a1aa/image/32c3dec0-13cf-4054-2972-392cfed886c8.jpg" width="28"/>
             <div class="w-7 h-7 rounded-full border-2 border-white bg-[#3ddbd9] text-white text-[11px] font-semibold flex items-center justify-center select-none">+</div>
         </div>
     </div>
     <div class="language-dropdown absolute top-6 right-6 z-20">
         <button aria-expanded="false" aria-haspopup="listbox" class="bg-[#f9b233] text-xs text-[#1a3ea8] font-semibold rounded-full px-5 py-1.5 flex items-center space-x-1 focus:outline-none">
             <span>English (EN)</span>
             <i class="fas fa-chevron-down text-[10px]"></i>
         </button>
     </div>
     <div class="quote-box absolute bottom-30 right-10">"Empowering you to live a healthier, happier life."</div>
     <div class="floating-icon icon2" title="Heartbeat">
         <i class="fas fa-heartbeat"></i>
     </div>
     <div class="floating-icon icon3" title="Stethoscope">
         <i class="fas fa-stethoscope"></i>
     </div>
     <div class="floating-icon icon4" title="Pills">
         <i class="fas fa-pills"></i>
     </div>
   </div>
   <div class="icon-cluster">
     <div class="icon-circle" title="Medical cross icon"><i class="fas fa-plus"></i></div>
     <div class="icon-circle" title="Heartbeat icon"><i class="fas fa-heartbeat"></i></div>
     <div class="icon-circle" title="Stethoscope icon"><i class="fas fa-stethoscope"></i></div>
   </div>
  </div>
 </body>
</html>