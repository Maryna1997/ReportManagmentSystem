function myclock()
{
ndata=new Date()
hours= ndata.getHours();
mins= ndata.getMinutes();
secs= ndata.getSeconds();
if (hours < 10) {hours = "0" + hours }
if (mins < 10) {mins = "0" + mins }
if (secs < 10) {secs = "0" + secs }
datastr =hours+":" + mins+":" +secs
document.clockexam.clock.value = " "+datastr;
setTimeout("myclock()", 1000);
}