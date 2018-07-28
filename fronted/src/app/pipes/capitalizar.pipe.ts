import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'capitalizar'
})
export class CapitalizarPipe implements PipeTransform {

  transform(value: string, args?: string): any {
    if(value == null)  return "No asignado";
    // return value.charAt(0).toUpperCase() + value.slice(1);
      return value.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1){
         return $1.toUpperCase(); 

  })
}}
  


