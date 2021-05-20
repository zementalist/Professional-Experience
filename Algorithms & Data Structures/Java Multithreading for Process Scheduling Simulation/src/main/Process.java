/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main;

/**
 *
 * @author Zeyad-Pc
 */
class Process {
  public String title;
  public int burst, arrival, turnaround, waiting, burstAsConst;
  Process(String title, int burst, int arrival) {
      this.title = title;
      this.burst = burst;
      this.arrival = arrival;
      this.turnaround = 0;
      this.waiting = 0;
      this.burstAsConst = burst; // To calculate waitingTime = turnaround - burst
  }
}
