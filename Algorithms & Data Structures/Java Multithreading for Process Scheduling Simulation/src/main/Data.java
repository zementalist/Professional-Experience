/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main;

import java.util.List;

/**
 *
 * @author Zeyad-Pc
 */
class Data {
  public int numberOfProcesses;
  public List<String> titles;
  public List<Integer> burstTimes;
  public List<Integer> arrivalTimes;
  Data(int numberOfProcesses, List titles, List burstTimes, List arrivalTimes) {
    this.numberOfProcesses = numberOfProcesses;
    this.titles = titles;
    this.burstTimes = burstTimes;
    this.arrivalTimes = arrivalTimes;
  }
}
 
