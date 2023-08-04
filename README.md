# Automatic Control of JTDX/WSJT-X/MSHV - ULTRON

**Created by:** LU9DCE  
**Copyright:** 2023 Eduardo Castillo  
**Contact:** castilloeduardo@outlook.com.ar  
**License:** [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International](https://creativecommons.org/licenses/by-nc-nd/4.0/)

## Description

ULTRON is a software tool designed for remotely or locally controlling programs like JTDX, MSHV, and WSJT-X. It is capable of running on both Windows and Linux platforms, supporting both 32-bit and 64-bit versions. The software requires the latest version of PHP to operate.

## Requirements

Before using ULTRON, make sure you have the following:

- Latest version of PHP installed
- List of required PHP modules (located at the end of the script)
- Radio software properly configured for optimal performance
- Recommendations for optimal usage:
  - Disable the Tx watchdog
  - Set the UDP server to point to the IP where this program is located
  - Enable sending logged QSO ADIF data
  - Do not filter UDP data
  - Adjust your firewall to allow data to pass through

To ensure that ULTRON makes calls only to contacts that belong to LoTW (Logbook of The World), create an empty file in the same folder named "lotw".

## Terminal and Color Support

ULTRON requires a terminal that supports ASCII color. You can use either the Linux terminal or the new Windows 10 or 11 terminal, both of which support ASCII color. If you're unable to see colors in Windows, it is recommended to use [ConEmu](https://conemu.github.io/) for an enhanced experience.

## Raspberry Pi LED Control

To control the LEDs of a Raspberry Pi, you will need to use the `sudo` command. Ensure that it is configured not to require a password.

## Disclaimer

"I am not responsible for the use or inability to use this software or any other."

