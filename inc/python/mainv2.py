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
 
# Define GPIO to LCD mapping
LCD_RS = 7
LCD_E  = 8
LCD_D4 = 25
LCD_D5 = 24
LCD_D6 = 23
LCD_D7 = 18
#LED_ON = 15
 
# Define some device constants
LCD_WIDTH = 20    # Maximum characters per line
LCD_CHR = True
LCD_CMD = False
 
LCD_LINE_1 = 0x80 # LCD RAM address for the 1st line
LCD_LINE_2 = 0xC0 # LCD RAM address for the 2nd line
LCD_LINE_3 = 0x94 # LCD RAM address for the 3rd line
LCD_LINE_4 = 0xD4 # LCD RAM address for the 4th line
 
# Timing constants
E_PULSE = 0.0005
E_DELAY = 0.0005

db =MySQLdb.connect("localhost","root","mjwin101","brewery")
cur = db.cursor()
 
def main():
  # Main program block
 
  GPIO.setmode(GPIO.BCM)       # Use BCM GPIO numbers
  GPIO.setup(LCD_E, GPIO.OUT)  # E
  GPIO.setup(LCD_RS, GPIO.OUT) # RS
  GPIO.setup(LCD_D4, GPIO.OUT) # DB4
  GPIO.setup(LCD_D5, GPIO.OUT) # DB5
  GPIO.setup(LCD_D6, GPIO.OUT) # DB6
  GPIO.setup(LCD_D7, GPIO.OUT) # DB7
  #GPIO.setup(LED_ON, GPIO.OUT) # Backlight enable
  GPIO.setup(15, GPIO.IN, pull_up_down=GPIO.PUD_UP) # KEY SW
  GPIO.setup(26, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Boil SW
  GPIO.setup(19, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Mash SW
  GPIO.setup(13, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Liquor SW
  GPIO.setup(22, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Step Button
  
  
  GPIO.setup(12, GPIO.OUT) # Element 1
  
  #Mfile = open("/sys/bus/w1/devices/28-800000044e56/w1_slave")
  #Lfile = open("/sys/bus/w1/devices/28-8000001ec5a0/w1_slave")
  #Pfile = open("/sys/bus/w1/devices/28-8000001f1360/w1_slave")
  
  # Initialise display
  lcd_init()
  
  my_ip = getifip('wlan0')
  step = 0
  i = 0
  start=time.time()

  
  while True:
    #time.sleep(1)
    Key_state = GPIO.input(15) #  if key switch is flipped
    Boil_state = GPIO.input(26) #  if Boil switch is flipped
    Mash_state = GPIO.input(19) #  if Mash switch is flipped
    Liquor_state = GPIO.input(13) #  if Liquor switch is flipped
    Step_state = GPIO.input(22) # Step Button
    print "Key"
    print Key_state
    
    if Key_state == True:
      my_ip = getifip('wlan0')
      step=0
      # Send some centred test
      lcd_string("Please Configure at",LCD_LINE_1,2)
      lcd_string(" ",LCD_LINE_2,2)
      lcd_string("http://"+my_ip,LCD_LINE_3,2)
      lcd_string("--------------------",LCD_LINE_4,2)
    
    else:    
      print'Key Switched'
      
      # if button pressed, step++
      if Step_state == False and i >9:
        step =step +1
        i=0
        start=time.time()
      
      i = i+1
      print'step'
      print step
      
      print'i'
      print i

      if step == 0:
        Steptxt="Heating HLT"
        timetxt=time.time()-start
        inputtxt= "HLT"
        temptxt= LiquorTemp()
      
      elif step == 1:
        Steptxt="Mash in"
        timetxt=time.time()-start
        inputtxt= "Mash Tun"
        temptxt=MashTemp()
       
      elif step == 2:
        Steptxt="Mashing & Heating HLT"
        timetxt=time.time()-start
        inputtxt= "HLT"
        temptxt= LiquorTemp()

      elif step == 3:
        Steptxt="recirculate"
        timetxt=time.time()-start
        inputtxt= "Mash"
        temptxt=MashTemp()
        
      elif step == 4:
        Steptxt="Preparing HLT"
        timetxt=time.time()-start
        inputtxt= "HLT"
        temptxt= LiquorTemp()        

      elif step == 5:
        Steptxt="Mash Out"
        timetxt=time.time()-start
        inputtxt= "HLT"
        temptxt= LiquorTemp()

        
      else: 
        Steptxt="OVER"
        timetxt=time.time()-start
        inputtxt= "HLT"
        temptxt= "THIS IS THE TEMP"
      

      lcd_string("Step: "+Steptxt,LCD_LINE_1,2)
      lcd_string("Time: "+str(timetxt),LCD_LINE_2,2)
      lcd_string("Input: "+inputtxt,LCD_LINE_3,2)
      lcd_string("Temp: "+ str(temptxt),LCD_LINE_4,2)


def LiquorTemp():
        Lfile = open("/sys/bus/w1/devices/28-8000001ec5a0/w1_slave")
        Ltext = Lfile.read()
        Lfile.close()
        Lsecondline = Ltext.split("\n")[1]
        Ltemperaturedata = Lsecondline.split(" ")[9]
        Ltemperature = float(Ltemperaturedata[2:])
        Ltemperature = Ltemperature / 1000
        Ltemperature = (Ltemperature * 1.8) + 32
                
        try:
                cur.execute("""insert into temp (temp,datetime,Point) values (%s,now(),"2");""",str(Ltemperature))
                db.commit()
        except:
                db. rollback()
        
        return Ltemperature
 
   
def MashTemp():
        Mfile = open("/sys/bus/w1/devices/28-800000044e56/w1_slave")
        Mtext = Mfile.read()
        Mfile.close()
        Msecondline = Mtext.split("\n")[1]
        Mtemperaturedata = Msecondline.split(" ")[9]
        Mtemperature = float(Mtemperaturedata[2:])
        Mtemperature = Mtemperature / 1000
        Mtemperature = (Mtemperature * 1.8) + 32
                
        try:
                cur.execute("""insert into temp (temp,datetime,Point) values (%s,now(),"1");""",str(Mtemperature))
                db.commit()
        except:
                db. rollback()
     
        return Mtemperature

 
def lcd_init():
  # Initialise display
  lcd_byte(0x33,LCD_CMD) # 110011 Initialise
  lcd_byte(0x32,LCD_CMD) # 110010 Initialise
  lcd_byte(0x06,LCD_CMD) # 000110 Cursor move direction
  lcd_byte(0x0C,LCD_CMD) # 001100 Display On,Cursor Off, Blink Off
  lcd_byte(0x28,LCD_CMD) # 101000 Data length, number of lines, font size
  lcd_byte(0x01,LCD_CMD) # 000001 Clear display
  time.sleep(E_DELAY)
 
def lcd_byte(bits, mode):
  # Send byte to data pins
  # bits = data
  # mode = True  for character
  #        False for command
 
  GPIO.output(LCD_RS, mode) # RS
 
  # High bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x10==0x10:
    GPIO.output(LCD_D4, True)
  if bits&0x20==0x20:
    GPIO.output(LCD_D5, True)
  if bits&0x40==0x40:
    GPIO.output(LCD_D6, True)
  if bits&0x80==0x80:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
 
  # Low bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x01==0x01:
    GPIO.output(LCD_D4, True)
  if bits&0x02==0x02:
    GPIO.output(LCD_D5, True)
  if bits&0x04==0x04:
    GPIO.output(LCD_D6, True)
  if bits&0x08==0x08:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
 
def getifip(ifn):
    sck = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    return socket.inet_ntoa(fcntl.ioctl(sck.fileno(),0x8915, struct.pack('256s', ifn[:15]))[20:24])
 
def lcd_toggle_enable():
  # Toggle enable
  time.sleep(E_DELAY)
  GPIO.output(LCD_E, True)
  time.sleep(E_PULSE)
  GPIO.output(LCD_E, False)
  time.sleep(E_DELAY)
 
def lcd_string(message,line,style):
  # Send string to display
  # style=1 Left justified
  # style=2 Centred
  # style=3 Right justified
 
  if style==1:
    message = message.ljust(LCD_WIDTH," ")
  elif style==2:
    message = message.center(LCD_WIDTH," ")
  elif style==3:
    message = message.rjust(LCD_WIDTH," ")
 
  lcd_byte(line, LCD_CMD)
 
  for i in range(LCD_WIDTH):
    lcd_byte(ord(message[i]),LCD_CHR)
 
def lcd_backlight(flag):
  # Toggle backlight on-off-on
  GPIO.output(LED_ON, flag)
 
if __name__ == '__main__':
 
  try:
    main()
  except KeyboardInterrupt:
    pass
  finally:
    lcd_byte(0x01, LCD_CMD)
    lcd_string("Goodbye!",LCD_LINE_1,2)
    GPIO.cleanup()
