# Initialize
# Display IP address and wait for inputs. 
# Turn on Boil Term
# Turn key to start timer

#import

import RPi.GPIO as GPIO
import socket, fcntl, struct
import os
import time
import MySQLdb

def main():
    print"works!"
    
    # coding: utf-8
    file = open('commands.txt','r')
    
    line = file.readline()
    
    while line:
        # ignore comments 
        if (line[0][0] !="#"):   
            print line
            command = (line.partition('='))[0]
            value = (line.partition('='))[2]
            
            if(command == "run"):
                run = value
            if(command == "step"):
                step = value
            if(command == "liqel"):
                liqel = value                
            if(command == "recir"):
                recir = value
            if(command == "liqelman"):
                liqelman = value
            if(command == "liqmashpump"):
                liqmashpump = value                
            if(command == "mashboilpump"):
                mashboilpump = value
            if(command == "timer"):
                timer = value
                
        line = file.readline()
                        
    file.close()

        
    
if __name__ == '__main__':
 
  try:
    main()
  except KeyboardInterrupt:
    pass
  finally:
    lcd_byte(0x01, LCD_CMD)
    lcd_string("Goodbye!",LCD_LINE_1,2)
    GPIO.cleanup()