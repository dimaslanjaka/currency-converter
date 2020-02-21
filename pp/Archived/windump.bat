::WinDump –D
::Then you can run the program on a particular adapter with the command
::WinDump –i adaptername
::or
::WinDump –i adapternumber

::windump -i 3 -q -w %CD% -n -C 30 -W 10 -U -s 0
::windump -i 3 -q -w %cwd% -n -C 30 -W 10 -U -s 0

@Echo OFF
set launchdir=%~dp0
set cwd=%CD%
set host=paypal.com
set dump="%cwd%\%host%.dump"
windump -i 3 -w DumpTrace.pcap -U -n dst host paypal.com
Pause&Exit