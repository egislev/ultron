# ULTRON - Automatic Control of JTDX/WSJT-X/MSHV 🤖

**Created by:** https://lu9dce.github.io/

**Copyright:** 2023 Eduardo Castillo  

**Contact:** castilloeduardo@outlook.com.ar  

**License:** https://creativecommons.org/licenses/by-nc-nd/4.0/

**I recommend AUTOSPOT:** https://github.com/lu9dce/autospot

## [DONATE](https://www.paypal.com/donate/?hosted_button_id=WHG8FQRMAPA3E)

Ayuda en español en la [Wiki!](https://github.com/lu9dce/ultron/wiki).

![ultron](https://pbs.twimg.com/media/F23jEfzWYAApY9t?format=webp&name=small)

## ⚙️ To run PHP in an optimized way, use the following commands:

To run it directly in the command line:

```bash
php -d opcache.enable_cli=1 -d opcache.jit_buffer_size=64M -d opcache.jit=1255 -d memory_limit=-1 robot.php
```

For example, to run it in the background, you can use:

```bash
tmux new-session -d -s robot 'cd /root/ultron && php -d opcache.enable_cli=1 -d opcache.jit_buffer_size=64M -d opcache.jit=1255 -d memory_limit=-1 robot.php > /dev/tty1 && tmux detach-client'
```

These commands will help you run your PHP script with optimizations either in the foreground or in the background using tmux.

## 📜 Description

ULTRON is a sophisticated software tool designed for **remotely or locally controlling programs like JTDX, MSHV, and WSJT-X**. It offers seamless operation on both **Windows and Linux platforms**, supporting both 32-bit and 64-bit versions. The software relies on the **latest version of PHP** for optimal performance.

## 🌟 Advantages of Using ULTRON

ULTRON offers a multitude of advantages as a **BOT** for controlling programs like JTDX, MSHV, and WSJT-X:

1. **Effortless Remote Control**: ULTRON empowers users with the ability to control radio programs remotely, eliminating the need for physical presence. This is particularly beneficial for scenarios where real-time adjustments and monitoring are required without being tied to a specific location.

2. **Enhanced Efficiency**: By automating repetitive tasks such as CQ calling and message recognition, ULTRON boosts operational efficiency. It can tirelessly manage communication, freeing up operators to focus on more strategic aspects of their radio activities.

3. **Seamless Integration**: ULTRON integrates seamlessly with both Windows and Linux platforms, providing a consistent and user-friendly experience across different operating systems. Its support for various versions ensures compatibility with a wide range of setups.

4. **Real-Time Adaptability**: The real-time functionality of ULTRON enables dynamic changes in software preferences without the need for frequent restarts. Users can switch between programs like JTDX, MSHV, and WSJT-X effortlessly, adapting to changing communication needs on the fly.

5. **Automated Logbook Management**: ULTRON's dedicated logbook management ensures accurate tracking of QSOs. The ability to use a personalized logbook while keeping it separate from other software simplifies record-keeping and QSO verification.

6. **Intelligent Decision-Making**: ULTRON's ability to identify messages, respond to correspondents, and manage waitlists demonstrates its intelligence in making informed decisions during communication. It streamlines the QSO process, increasing the chances of successful interactions.

7. **Signal Strength Assessment**: ULTRON's consideration of signal strength enhances QSO success rates. By taking into account signals weaker than -20dB, it assists in prioritizing communications with better chances of success.

8. **Visual Feedback**: For Raspberry Pi users, the LED control and audible tone features provide visual and audio feedback, enhancing user awareness of ongoing operations and the status of the communication process.

In summary, employing ULTRON as a BOT for radio program control offers an array of benefits, ranging from operational efficiency and adaptability to intelligent decision-making and enhanced communication success rates. Its seamless integration, real-time capabilities, and intelligent automation make ULTRON a valuable asset in the world of amateur radio communication.

🚀 **Try ULTRON today and elevate your amateur radio experience!** 🚀

## 🔧 Requirements

Before utilizing ULTRON, please ensure the following prerequisites are met:
- Latest version of **PHP** installed
- List of required **PHP modules** (specified at the end of the script)
- Properly configured radio software for optimal performance
- Recommendations for optimal usage:
  - Disable the Tx watchdog
  - Configure the UDP server to target the program's IP location
  - Enable transmission of logged QSO ADIF data
  - Do not filter UDP data
  - Adjust firewall settings to facilitate data flow

## 📋 Details

- ULTRON operates in **real-time**, allowing seamless software switches without requiring restarts. It automatically detects your **call sign**, **IP address**, and communication ports.
- ULTRON uses its own **logbook**, but you can provide your own by placing it in the "**wsjtx_log.adi**" folder within ULTRON. This logbook remains separate from other software.
- In addition to calling CQ, ULTRON recognizes messages like **73** or **RR73** and determines if correspondents are busy or unresponsive.
- If a correspondent doesn't respond, they will be **waitlisted for 30 minutes** before a QSO retry.
- Signals weaker than **-20dB** are considered less likely to result in successful QSOs.
- The logged ADIF message is sent to ULTRON when the WSJT-X user accepts the "Log  QSO" dialog by clicking the "OK" button.

## 🌈 Terminal and Color Support

ULTRON requires a terminal with **ASCII color support**. You can use the **Linux terminal** or the new **Windows 10/11 terminal**, both of which support ASCII color. For color support on Windows, consider using [**ConEmu**](https://conemu.github.io/) for an enhanced experience.

## 🍓 Raspberry Pi

To control Raspberry Pi LEDs, use the `sudo` command configured without a password prompt. The **green LED** lights up for each decoding and turns off when inactive. The **red LED** exhibits a heartbeat-like effect during QSOs. Conducting a QSO emits an audible tone if a speaker is connected to the Pi's jack.

## 💻 ULTRON Execution Instructions

To run ULTRON on both Windows and Linux, you have several options:

1. **Terminal Execution:**
   You can execute ULTRON directly through the terminal by running the following command: `php robot.php`

2. **Batch Script (Windows) or Shell Script (Linux):**
Alternatively, you can create a batch script (.BAT) for Windows or a shell script (.sh) for Linux with the necessary commands to execute ULTRON.

3. **Task Scheduler:**
You may also utilize a task scheduler to run ULTRON in the background upon system startup.

Please note the following important considerations:

- ULTRON requires specific modules. Please ensure that you have the required modules installed. Refer to the "robot.php" file for the list of requirements.
- Make necessary modifications to the "php.ini" configuration to meet the requirements of ULTRON.

For reference, an example "php.ini" configuration is provided in the "extras" folder.

For any further assistance, please refer to the documentation or contact our support team.

Thank you for using ULTRON!

## ⚠️ Disclaimer

"I am not liable for the use or inability to use this software or any other."

## 😎 **PHP**

**Windows:**

**PHP 8.2 Installation:**

1. Download the PHP 8.2 installer for Windows from the official PHP website (https://windows.php.net/download/).
2. Run the installer and follow the instructions to complete the installation. Make sure to add the PHP installation path to the system PATH during installation.

**Adjust php.ini (if needed):**

- If your "robot.php" script requires specific configurations in the php.ini file, such as memory settings or execution limits, open the php.ini file in a text editor and make the necessary changes.

**Running the Script:**

1. Open the Command Prompt (cmd.exe).
2. Navigate to the location where your "robot.php" file is located using the `cd path\to\the\file` command.
3. Execute the script using the `php robot.php` command.

**Linux:**

**PHP 8.2 Installation:**

1. Open the terminal.
2. Execute the following commands to add the Ondřej Surý repository and install PHP 8.2:

   ```bash
   sudo apt-get install ca-certificates apt-transport-https
   wget -q https://packages.sury.org/php/apt.gpg -O- | sudo gpg --dearmor -o /usr/share/keyrings/php-archive-keyring.gpg
   echo "deb [signed-by=/usr/share/keyrings/php-archive-keyring.gpg] https://packages.sury.org/php/ $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/php.list
   sudo apt update
   sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath php8.2-xmlrpc php8.2-intl php8.2-soap php8.2-readline
   ```

**Adjust php.ini (if needed):**

- If your "robot.php" script requires specific configurations in the php.ini file, open the php.ini file in a terminal-based text editor like nano or vim, and make the necessary changes.

**Running the Script:**

1. In the terminal, navigate to the location where your "robot.php" file is located using the `cd path/to/the/file` command.
2. Run the script using the `php8.2 robot.php` command.

Make sure that the "robot.php" file contains the PHP code you want to execute. If you need to adjust the php.ini file, make sure to do so before running the script so that the configurations take effect.

## 🙋‍♂️ Thinking

Ultron was developed by me for me and some friends. It requires the user to have prior knowledge in using PHP and knowing how to use a Windows or Linux terminal. That's no longer up to me, but I guarantee you Ultron works very well. It can operate for years without the need for intervention.

**Why PHP!** Because it runs on any operating system and no compilation is needed. The script is just text with commands. Ultron will execute on any device that can run PHP (PC/CELLPHONE/ROUTER... ETC).

## 🖥️ Devices that Can Run PHP

- Personal Computers (PC) with Windows, macOS, or Linux.
- Smartphones and tablets with iOS, Android, etc.
- Web servers (Linux, Windows Server, etc.).
- Network devices (routers, switches, etc.).
- Internet of Things (IoT) devices with processing capabilities.
- Development boards like Raspberry Pi (Linux).
- Modified gaming consoles.
- Smart TVs and multimedia devices.
- Some printers and multifunctional devices.
- Industrial control systems and embedded devices.
