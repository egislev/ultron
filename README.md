# ULTRON - Automatic Control of JTDX/WSJT-X/MSHV 🤖

**Created by:** LU9DCE  
**Copyright:** 2023 Eduardo Castillo  
**Contact:** castilloeduardo@outlook.com.ar  
**License:** [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International](https://creativecommons.org/licenses/by-nc-nd/4.0/)

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

To ensure ULTRON makes calls only to contacts belonging to **LoTW (Logbook of The World)**, create an empty file named "**lotw**" within the same folder.

## 📋 Details

- ULTRON operates in **real-time**, allowing seamless software switches without requiring restarts. It automatically detects your **call sign**, **IP address**, and communication ports.
- ULTRON uses its own **logbook**, but you can provide your own by placing it in the "**wsjtx_log.adi**" folder within ULTRON. This logbook remains separate from other software.
- In addition to calling CQ, ULTRON recognizes messages like **73** or **RR73** and determines if correspondents are busy or unresponsive.
- If a correspondent doesn't respond, they will be **waitlisted for 30 minutes** before a QSO retry.
- Signals weaker than **-20dB** are considered less likely to result in successful QSOs.

## 🌈 Terminal and Color Support

ULTRON requires a terminal with **ASCII color support**. You can use the **Linux terminal** or the new **Windows 10/11 terminal**, both of which support ASCII color. For color support on Windows, consider using [**ConEmu**](https://conemu.github.io/) for an enhanced experience.

## 🍓 Raspberry Pi

To control Raspberry Pi LEDs, use the `sudo` command configured without a password prompt. The **green LED** lights up for each decoding and turns off when inactive. The **red LED** exhibits a heartbeat-like effect during QSOs. Conducting a QSO emits an audible tone if a speaker is connected to the Pi's jack.

## ⚠️ Disclaimer

"I am not liable for the use or inability to use this software or any other."
