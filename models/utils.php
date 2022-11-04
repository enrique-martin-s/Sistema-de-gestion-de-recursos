<?php

// Utilidades usadas en varias partes de la aplicación

class Utils {

public static function dayTranslator($day){
  switch($day){
    case "monday":
      return "Lunes";
      break;
    case "tuesday":
      return "Martes";
      break;
    case "wednesday":
      return "Miércoles";
      break;
    case "thursday":
      return "Jueves";
      break;
    case "friday":
      return "Viernes";
      break;
    case "saturday":
      return "Sábado";
      break;
    case "sunday":
      return "Domingo";
      break;
        }
    }
    static function monthTranslator($month){
      switch($month){
        case "january":
          return "Enero";
          break;
        case "february":
          return "Febrero";
          break;
        case "march":
          return "Marzo";
          break;
        case "april":
          return "Abril";
          break;
        case "may":
          return "Mayo";
          break;
        case "june":
          return "Junio";
          break;
        case "july":
          return "Julio";
          break;
        case "august":
          return "Agosto";
          break;
        case "september":
          return "Septiembre";
          break;
        case "october":
          return "Octubre";
          break;
        case "november":
          return "Noviembre";
          break;
        case "december":
          return "Diciembre";
          break;
      }
    }
}