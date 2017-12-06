# To turn on pin 4: python gpio.py 4 0
# To turn off pin 4: python gpio.py 4 1
import sys
import RPi.GPIO as GPIO
import time

state1 = int(sys.argv[1])
state2 = int(sys.argv[2])
state3 = int(sys.argv[3])
state4 = int(sys.argv[4])

GPIO.setmode(GPIO.BCM)

GPIO.setup(4, GPIO.OUT)
GPIO.setup(17, GPIO.OUT)
GPIO.setup(22, GPIO.OUT)
GPIO.setup(10, GPIO.OUT)

GPIO.output(4, (state1 != 1))
GPIO.output(17, (state2 != 1))
GPIO.output(22, (state3 != 1))
GPIO.output(10, (state4 != 1))

time.sleep(1)