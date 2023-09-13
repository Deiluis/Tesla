import platform
import subprocess
import requests
import json
import psutil
import datetime

def Storage():
    disks = []
    for disk in psutil.disk_partitions():
        disks.append({
            "name": disk.device + "\\",
            "memory": "{:.0f} GB".format(psutil.disk_usage(disk.device).total / (1024**3))
        })
    return disks

def CpuInfo():
    try:
        import winreg
    except ImportError as err:
            pass
    key = winreg.OpenKey(winreg.HKEY_LOCAL_MACHINE, r"Hardware\Description\System\CentralProcessor\0")
    value = winreg.QueryValueEx(key, "ProcessorNameString")[0]
    winreg.CloseKey(key)
    return value

def RAMInfo():
    data = str(subprocess.check_output(['wmic', 'memorychip', 'get', 'manufacturer', ',' ,'speed']))
    ddr = str(subprocess.check_output(['wmic', 'memorychip', 'get', 'memorytype'])).split("\\r\\r\\n")[1].replace(' ', '');
    if(ddr == '24'):
        ddr = 'DDR3'
    else: 
        ddr = 'DDR4'
    return  {
                "memory": "{:.0f} GB".format(psutil.virtual_memory().total / (1024**3)),
                "model": data.split("\\r\\r\\n")[1].replace('   ', ' ').replace('  ', ' ') + "MHz " +ddr
            }

def Arch():
    import re

    arch, bits = None, None
    arch_string_raw = platform.machine().lower()

	# X86
    if re.match(r'^i\d86$|^x86$|^x86_32$|^i86pc$|^ia32$|^ia-32$|^bepc$', arch_string_raw):
        arch = 'X86_32'
        bits = 32
    elif re.match(r'^x64$|^x86_64$|^x86_64t$|^i686-64$|^amd64$|^ia64$|^ia-64$', arch_string_raw):
        arch = 'X86_64'
        bits = 64
    # ARM
    elif re.match(r'^armv8-a|aarch64|arm64$', arch_string_raw):
        arch = 'ARM_8'
        bits = 64
    elif re.match(r'^armv7$|^armv7[a-z]$|^armv7-[a-z]$|^armv6[a-z]$', arch_string_raw):
        arch = 'ARM_7'
        bits = 32
    elif re.match(r'^armv8$|^armv8[a-z]$|^armv8-[a-z]$', arch_string_raw):
        arch = 'ARM_8'
        bits = 32
    # PPC
    elif re.match(r'^ppc32$|^prep$|^pmac$|^powermac$', arch_string_raw):
        arch = 'PPC_32'
        bits = 32
    elif re.match(r'^powerpc$|^ppc64$|^ppc64le$', arch_string_raw):
        arch = 'PPC_64'
        bits = 64
    # SPARC
    elif re.match(r'^sparc32$|^sparc$', arch_string_raw):
        arch = 'SPARC_32'
        bits = 32
    elif re.match(r'^sparc64$|^sun4u$|^sun4v$', arch_string_raw):
        arch = 'SPARC_64'
        bits = 64
    # S390X
    elif re.match(r'^s390x$', arch_string_raw):
        arch = 'S390X'
        bits = 64
    # MIPS
    elif re.match(r'^mips$', arch_string_raw):
        arch = 'MIPS_32'
        bits = 32
    elif re.match(r'^mips64$', arch_string_raw):
        arch = 'MIPS_64'
        bits = 64
    # RISCV
    elif re.match(r'^riscv$|^riscv32$|^riscv32be$', arch_string_raw):
        arch = 'RISCV_32'
        bits = 32
    elif re.match(r'^riscv64$|^riscv64be$', arch_string_raw):
        arch = 'RISCV_64'
        bits = 64
    # LoongArch
    elif re.match(r'^loongarch32$', arch_string_raw):
        arch = 'LOONG_32'
        bits = 32
    elif re.match(r'^loongarch64$', arch_string_raw):
        arch = 'LOONG_64'
        bits = 64
    if not arch in ['ARM_7', 'ARM_8',
	                'LOONG_32', 'LOONG_64',
	                'MIPS_32', 'MIPS_64',
	                'PPC_32', 'PPC_64',
	                'RISCV_32', 'RISCV_64',
	                'SPARC_32', 'SPARC_64',
	                'S390X',
	                'X86_32', 'X86_64']:
        raise Exception("Arquitectura desconocida")
    return f"{arch} - {bits} bits"

def Programs():
    data = str(subprocess.check_output(['wmic', 'product', 'get', 'name']))
    text = []
    try:
        for i in range(len(data)):
            text.append(data.split("\\r\\r\\n")[1:][i].strip())
    except IndexError as e:
        print("Listo")
    return text

if __name__ == '__main__':
    data =   {
                "host": platform.node(),
                "so":   {
                            "name" :f"{platform.system()} {platform.release()}",
                            "arch" : Arch()
                        },
                "cpu": CpuInfo(),
                "ram": RAMInfo(),
                "storage": Storage(),
                "programs": Programs(),
                "timestamp": datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
                "varios": {
                            "lastboot": datetime.datetime.fromtimestamp(psutil.boot_time()).strftime("%Y-%m-%d %H:%M:%S")
                          }
            }
    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}
    requests.post('http://181.45.18.185:7777/api/computers', data=json.dumps(data), headers=headers)
