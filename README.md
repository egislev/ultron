# ULTRON - Automatic Control of JTDX/WSJT-X/MSHV 🤖

**Created by:** LU9DCE  
**Copyright:** 2023 Eduardo Castillo  
**Contact:** castilloeduardo@outlook.com.ar  
**License:** [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International](https://creativecommons.org/licenses/by-nc-nd/4.0/)

## 📜 Description

ULTRON is a sophisticated software tool designed for **remotely or locally controlling programs like JTDX, MSHV, and WSJT-X**. It offers seamless operation on both **Windows and Linux platforms**, supporting both 32-bit and 64-bit versions. The software relies on the **latest version of PHP** for optimal performance.

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
